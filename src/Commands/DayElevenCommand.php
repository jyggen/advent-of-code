<?php
namespace Boo\AdventOfCode\Commands;

class DayElevenCommand extends DayCommandAbstract
{
    protected $testDataOne = [
        'abcdefgh' => 'abcdffaa',
        'ghijklmn' => 'ghjaabcc',
    ];

    protected $testDataTwo = [
    ];

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Corporate Policy');
    }

    protected function normalizeData(array $input)
    {
        return $input;
    }

    protected function getDayNumber()
    {
        return 11;
    }
    protected function perform(array &$input)
    {
        $password = $input[0];

        do {
            $password++;
        } while ($this->isValidPassword($password) === false);

        $password2 = $password;

        do {
            $password2++;
        } while ($this->isValidPassword($password2) === false);

        return [$password, $password2];
    }

    protected function isValidPassword($password)
    {
        if (preg_match_all('/([a-z])\1{1}/', $password) < 2) {
            return false;
        }

        if (preg_match('/[i,o,l]/', $password) !== 0) {
            return false;
        }

        $password = str_split($password);
        $length   = count($password) - 2;
        $found    = false;

        for ($i = 0; $i < $length; $i++) {
            if ($password[$i+1] === chr(ord($password[$i])+1) && $password[$i+2] === chr(ord($password[$i])+2)) {
                $found = true;
                break;
            }
        }

        if ($found === false) {
            return false;
        }

        return true;
    }
}
