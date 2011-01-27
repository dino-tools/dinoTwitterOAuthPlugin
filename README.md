# NAME

dinoTwitterOAuthPlugin

# WHAT IS THIS?

OAuth 経由で [Twitter](http://twitter.com) につぶやきを投稿するための Symfony 1.0/1.4 用 plugin です。

# INSTALL

PROJECT_DIR/plugins/ 以下に配置し、apps/frontend/config/settings.yml に以下の様に書いて下さい。

    # Activated modules from plugins or from the symfony core
    enabled_modules:        [default, dinoTwitterOAuth]

また、 apps/frontend/config/app.yml に以下の様に書いて下さい。

    all:
      twitter:
        consumer_key:          xxxxxxxxxxxxxxxxxxxxx
        consumer_secret:       xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
        callback_url:          http://example.com/
        callback_redirect_url: http://your.example.com/

# CHANGELOG

* 2011/01/07 初版

# AUTHOR

* tsukimiya
* xcezx
