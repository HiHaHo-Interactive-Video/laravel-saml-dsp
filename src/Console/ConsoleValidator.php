<?php

namespace HiHaHo\Saml\Console;

use Illuminate\Support\Facades\Validator;

trait ConsoleValidator
{
    protected function rule($ruleName)
    {
        return array_only($this->rules(), $ruleName);
    }

    protected function askValidated($ruleName, $question, $default = null)
    {
        $result = $this->ask($question, $default);
        $rule = $this->rule($ruleName);

        $validator = Validator::make([$ruleName => $result], $rule);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return $this->askValidated($ruleName, $question, $default);
        }

        return $result;
    }
}
