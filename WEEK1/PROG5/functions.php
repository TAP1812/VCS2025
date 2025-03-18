<?php

    /**
     * Sanitizes user input to prevent XSS attacks.
     *
     * @param string $data The input data.
     * @return string The sanitized data.
     */
    function sanitize_input(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Displays an error message.
     *
     * @param string $message The error message.
     */
    function display_error(string $message): void
    {
        echo '<div class="error">' . sanitize_input($message) . '</div>';
    }

    /**
     * Displays a success message.
     *
     * @param string $message The success message.
     */
    function display_success(string $message): void
    {
        echo '<div class="success">' . sanitize_input($message) . '</div>';
    }


    /**
     * Escapes data for safe use in HTML attributes.
     *
     * @param string $data The data to escape.
     * @return string The escaped data.
     */
    function escape_html_attr(string $data): string
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
?>