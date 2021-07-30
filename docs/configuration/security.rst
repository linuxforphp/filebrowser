.. _SecurityAnchor:

========
Security
========

.. index:: Security

--------------------------------
Configuring the Security Service
--------------------------------

.. index:: Security configuration

A simple security service is included in the application by default. This
service provides:

-  A basic session-based
   `CSRF <https://en.wikipedia.org/wiki/Cross-site_request_forgery>`__
   protection,
-  An IP allow list,
-  An IP deny list.

::

    'Filebrowser\Services\Security\Security' => [
       'handler' => '\Filebrowser\Services\Security\Security',
       'config' => [
           'csrf_protection' => true,
           'csrf_key' => "123456", // randomize this
           'ip_allowlist' => [],
           'ip_denylist' => [
               '172.16.1.2',
               '172.16.3.4',
           ],
       ],
    ],

If you set the ``ip_allowlist`` option, then only users coming from the listed IP
addresses will be able to use the application.
