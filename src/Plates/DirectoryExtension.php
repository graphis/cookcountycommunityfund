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

    public function contact(array $row)
    {
        if (empty($row['contact_firstname'])) {
            return '';
        }

        if (strpos($row['contact_firstname'], ',') !== false) {
            $names = array_combine(
                preg_split('/,\s*/', $row['contact_firstname']),
                preg_split('/,\s*/', $row['contact_lastname'])
            );

            $contacts = [];
            foreach ($names as $contact_firstname => $contact_lastname) {
                $contacts[] = $this->contact(compact('contact_firstname', 'contact_lastname'));
            }
            return implode(' <br>', $contacts);
        }

        $contact = trim(sprintf(
            '%s %s',
            $row['contact_firstname'],
            $row['contact_lastname']
        ));

        return $this->escape($contact);
    }

    public function phone(array $row)
    {
        if (empty($row['phone'])) {
            return '';
        }

        $numbers = preg_split('/;\s*/', $row['phone']);

        return $this->escape($numbers[0]);
    }

    public function email(array $row)
    {
        if (empty($row['email']) || strpos($row['email'], '@') === false) {
            return '';
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

    private function link($name, $link)
    {
        return sprintf(
            '<a href="%s" target="_blank">%s</a>',
            $this->escape($link),
            $name
        );
    }

    private function none()
    {
        return '<em class="text-muted">&mdash;</em>';
    }
}
