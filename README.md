# m2_customer_address

install docker for project

curl -s https://raw.githubusercontent.com/clean-docker/Magento2/master/init | bash -s MYMAGENTO2 clone

cd MYMAGENTO2

./shell

rm index.php

git clone THIS repostiory

exit

in MYMAGENTO2 dir:

./composer install

php bin/magento setup:install --base-url=http://test-m2.loc --db-host=db --db-name=magento --db-user=magento --admin-firstname=Magento --admin-lastname=User --admin-email=my@email.com --admin-user=admin --admin-password=password123 --language=en_US --currency=USD --timezone=Europe/Warsaw --use-rewrites=1 --backend-frontname=admin