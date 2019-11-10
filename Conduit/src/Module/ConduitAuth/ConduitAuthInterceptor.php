<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth;

use Aura\Web\Request;
use PDO;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\AuraSqlModule\AuraSqlInject;
use Ray\AuraSqlModule\AuraSqlSelectInject;

final class ConduitAuthInterceptor implements MethodInterceptor
{
    use AuraSqlInject;
    use AuraSqlSelectInject;

    private $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $authorization = $this->request->headers->get('authorization', '');
        if ($authorization === '') {
            throw new UnauthorizedException('No token given');
        }

        $needle = 'Token ';
        if (strpos($authorization, $needle) !== 0) {
            throw new ForbiddenException('Invalid format');
        }

        $token = substr($authorization, strlen($needle));
        $this->select->from('user')->cols(['id'])->where('token=:token')->bindValue('token', $token);
        $sth = $this->pdo->prepare($this->select->getStatement());

        // bind the values and execute
        $sth->execute($this->select->getBindValues());

        /** @var $result array|false */
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        if (!$result){
            throw new ForbiddenException('No user found');
        }

        return $invocation->proceed();
    }
}