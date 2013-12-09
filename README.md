#### Description

This bundle helps you to accumulate and browse errors in the production environment. Repetitive errors are grouped together.

#### Installation

1. In your composer.json require section:

    "twodudes/error-logger-bundle": "dev-master"

2. In your routing.yml:

```

    two_dudes_errors:
        resource: "@TwoDudesErrorLoggerBundle/Resources/config/routing.yml"

```

3. In your config.prod:

```

two_dudes:
  error_logger:
    storage:
      service: two_dudes.storage.db
      params:
        db_host: xxxxx
        db_port: xxxxx
        db_name: xxxxx
        db_user: xxxxx
        db_password: xxxxx

```

Now you can access /_errors page, where everything will be displayed. Don't forget to protect it with a firewall.