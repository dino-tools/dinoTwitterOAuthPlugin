# dinoTwitterOAuthPlugin

## これは何?

[Twitter](http://twitter.com) に OAuth で tweet を post するプラグイン。

## インストール

apps/frontend/config/settings.yml に以下の様に書いて下さい。

    # Activated modules from plugins or from the symfony core
    enabled_modules:        [default, dinoTwitterOAuth]

また、 apps/frontend/config/app.yml に以下の様に書いて下さい。

    all:
      twitter:
        consumer_key: xxxxxxxxxxxxxxxxxxxxx
        consumer_secret: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
        callback_url: http://example.com/
