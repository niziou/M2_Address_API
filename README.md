<a href="http://fvcproductions.com"><img src="https://avatars1.githubusercontent.com/u/4284691?v=3&s=200" title="FVCproductions" alt="FVCproductions"></a>

<!-- [![FVCproductions](https://avatars1.githubusercontent.com/u/4284691?v=3&s=200)](http://fvcproductions.com) -->

# Magento2 Customer Address REST API module

## Table of Contents

- [Installation](#installation)
- [FAQ](#faq)
- [Support](#support)
- [License](#license)


## Installation

Install docker for project

curl -s https://raw.githubusercontent.com/clean-docker/Magento2/master/init | bash -s MYMAGENTO2 clone

cd MYMAGENTO2

./shell

rm index.php

git clone THIS repostiory

exit

in MYMAGENTO2 dir:

./composer install

php bin/magento setup:install --base-url=http://test-m2.loc --db-host=db --db-name=magento --db-user=magento --admin-firstname=Magento --admin-lastname=User --admin-email=my@email.com --admin-user=admin --admin-password=password123 --language=en_US --currency=USD --timezone=Europe/Warsaw --use-rewrites=1 --backend-frontname=admin


### Setup

/composer install

php bin/magento setup:install --base-url=http://test-m2.loc --db-host=db --db-name=magento --db-user=magento --admin-firstname=Magento --admin-lastname=User --admin-email=my@email.com --admin-user=admin --admin-password=password123 --language=en_US --currency=USD --timezone=Europe/Warsaw --use-rewrites=1 --backend-frontname=admin
## FAQ

---

## Support

---

## License

[![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](http://badges.mit-license.org)

- **[MIT license](http://opensource.org/licenses/mit-license.php)**
- Copyright 2015 © <a href="http://fvcproductions.com" target="_blank">FVCproductions</a>.
