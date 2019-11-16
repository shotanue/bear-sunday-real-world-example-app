<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth\Login;

use Acme\Conduit\Module\ConduitAuth\Exceptions\ForbiddenException;
use Acme\Conduit\Module\ConduitAuth\Token\Token;
use Aura\Sql\ExtendedPdoInterface;
use Aura\SqlQuery\Common\SelectInterface;
use Ray\AuraSqlModule\AuraSqlInject;
use Ray\AuraSqlModule\AuraSqlSelectInject;

final class Login
{
    use AuraSqlInject;
    use AuraSqlSelectInject;

    /**
     * @var Token
     */
    private $token;

    public function __construct(Token $token,ExtendedPdoInterface $extendedPdo,SelectInterface $select)
    {
        $this->token = $token;
        $this->setAuraSql($extendedPdo);
        $this->setAuraSqlSelect($select);
    }

    public function __invoke(): int
    {
        $resolve = function (string $token): int {
            $this->select->from('user')
                ->cols(['id'])
                ->where('token=:token')
                ->bindValue('token', $token);

            $sth = $this->pdo->prepare($this->select->getStatement());

            // bind the values and execute
            $sth->execute($this->select->getBindValues());

            /** @var $result array|false */
            $result = $sth->fetch();

            // zero should be fail to login.
            $isFound = (bool)($result['id'] ?? false);
            if (!$isFound) {
                throw new ForbiddenException('No user found');
            }

            return $result['id'];
        };

        $token = $this->token->asString();

        return ($resolve)($token);
    }
}