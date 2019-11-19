<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Error;

final class ParseJsonSchemaMsg
{
    /**
     * sample error message
     * [email] Invalid email; [username] Must be at least 1 characters long; by /var/app/var/json_validate/users.post.json
     *
     * convert to
     * ['email' => 'Invalid email', 'username' => ' Must be at least 1 characters long']
     * @param string $message
     * @return array
     */
    public static function parse(string $message): array
    {
        $errors = [];
        foreach (explode(';', $message) as $str) {
            // trim head spaces
            $str = preg_replace('/\s+\[/', '[', $str);
            if ($str[0] !== '[') {
                continue;
            }

            $arr = explode('] ', $str);
            $key = str_replace('[', '', $arr[0]);
            $errors[$key] = $arr[1];
        }
        return $errors;
    }
}