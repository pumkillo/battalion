<?php
function renderErrors(array &$array, string $key): void
{
    if (isset($array[$key])) {
        foreach ($array[$key] as $val) {
            echo '<p class="errors text-danger">' . $val . '</p>';
        }
    }
}

function renderError($errorMessage): void
{
    echo '<p class="errors text-danger">' . $errorMessage . '</p>';
}
