<?php

/**
 * Class EmailValidator
 */
Class EmailValidator
{
    /**
     * Validate email using regexp
     * @param string $email
     * @return bool
     */
    public function validateRegexpEmail(string $email): bool
    {
        return preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email);
    }

    /**
     * Validate email using MX records
     * @param string $email
     * @return bool
     */
    public function validateMxEmail(string $email): bool
    {
        list($user, $domain) = explode('@', $email);
        $arr = dns_get_record($domain, DNS_MX);

        if (isset($arr[0]['host']) && $arr[0]['host'] == $domain && !empty($arr[0]['target'])) {
            return true;
        }

        return false;
    }

    /**
     * Validate multiple emails
     * @param array $emails
     * return array only valid emails
     */
    public function filterEmailsList(array $emails): array
    {
        $res = [];

        foreach($emails as $email) {
            if($this->validateRegexpEmail($email) && $this->validateMxEmail($email)) {
                $res[] = $email;
            }
        }

        return $res;
    }
}
