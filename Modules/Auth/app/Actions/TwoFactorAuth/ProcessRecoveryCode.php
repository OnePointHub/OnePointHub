<?php

namespace Modules\Auth\Actions\TwoFactorAuth;

class ProcessRecoveryCode
{
    /**
     * Verify a recovery code and remove if from the list if valid.
     */
    public function __invoke(array $recoveryCodes, string $submittedCode): false|array
    {
        // Clean the submitted code
        $submittedCode = trim($submittedCode);

        // If the user has entered multiple codes, only validate the first one
        $submittedCode = explode(' ', $submittedCode)[0];

        // Check if the code is valid
        if (! in_array($submittedCode, $recoveryCodes)) {
            return false;
        }

        // Remove the used recovery code from the list
        $updatedCodes = array_values(array_filter($recoveryCodes, function ($code) use ($submittedCode) {
            return ! hash_equals($code, $submittedCode);
        }));

        return $updatedCodes;
    }
}
