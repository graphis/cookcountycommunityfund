<?php

namespace Northwoods\CCCF\Plates;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class DirectoryExtension implements ExtensionInterface
{
    public function register(Engine $template)
    {
        $template->registerFunction('directory', function () {
            return $this;
        });
    }

    public function name(array $row)
    {
        $name = $this->escape($row['name']);

        if (!empty($row['website'])) {
            $name = $this->link($name, $row['website']);
        }

        if (!empty($row['parent'])) {
            $name .= sprintf(
                '<br><small class="text-muted">%s</small>',
                $this->escape($row['parent'])
            );
        }

        return $name;
    }

    public function address(array $row)
    {
        $address = implode("\n", [
            $row['mailing_address'] ?: $row['physical_address'],
            $row['city'] . ', ' . $row['state'] . ' ' . $row['zip'],
        ]);

        $address = nl2br(trim($this->escape($address)));

        return sprintf('<address>%s</address>', $address);
    }

    public function phone(array $row)
    {
        return preg_split('/;\s*/', $row['phone'])[0];
    }

    public function email(array $row)
    {
        if (empty($row['email']) || strpos($row['email'], '@') === false) {
            return $this->none();
        }

        $email = $this->escape($row['email']);

        return sprintf(
            '<a href="mailto:%s">%s</a>',
            $email,
            $email
        );
    }

    private function escape($str)
    {
        return htmlspecialchars($str, ENT_HTML5);
    }

    private function none()
    {
        return '<em class="text-muted">&mdash;</em>';
    }

    private function link($name, $link)
    {
        return sprintf(
            '<a href="%s" target="_blank">%s</a>',
            $this->escape($link),
            $name
        );
    }
}
