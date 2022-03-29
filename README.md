# Configuring prestashop in multiple stateless servers (scalable) with ansible
This repository (https://github.com/rrodolfos/prestashop-nginx-scalable-vagrant-ansible.git) contains vagrant and ansible configuration to deploy and provision prestashop in multiple stateless servers (scalable) with mysql (mariadb), redis, nfs, nginx and php (fpm):

  - [Prestashop](https://www.prestashop.com/)
  - [MariaDB](https://mariadb.org/) or ~~[MySQL](https://www.mysql.com/)~~
  - [Redis](https://redis.io/)
  - [NFS (Network File System)](https://datatracker.ietf.org/doc/html/rfc3010)
  - [NGINX](https://www.nginx.org/)
  - [php](https://www.php.net/)

## DISCLAIMER
> This implementation is intended for testing / PoC / educational purposes only, this solution is not ~~scalable or~~ secure enough for live / production environments. Use it at your own risk. Have fun!.

## Requirements
The below requirements are needed to deploy and provision Shop and PrestaShop VMs.

  - [VirtualBox](https://www.virtualbox.org/)
  - [Vagrant](https://www.vagrantup.com/)
  - [Ansible](https://www.ansible.com/)
  - [MySQL collection for Ansible](https://docs.ansible.com/ansible/latest/collections/community/mysql/index.html)

## what did I use for this?
  - MacBook Pro 2015 CPU Core i5 8GB RAM
  - OS GNU Linux/Debian 12 Bookworm 64bits
  - VirtualBox 6.1.32
  - Vagrant 2.2.19
    - Vagrant box debian/bullseye64
  - Ansible 2.12.3
  - MySQL collection for Ansible 2.1.0

## Included content
  - Vagrantfile
  - ansible.cfg
  - Collections
    - mysql
  - Playbook.yml
  - Roles
    - common
    - prestashop
    - shop

### Vagrantfile
VM machines definition as follow:
  - shop
    - 2 vcpu
    - 1024 RAM
    - 192.168.33.13 VM ip address

  - prestashop-1
    - 2 vcpu
    - 1024 RAM
    - 192.168.33.14 VM ip address
  
  - prestashop-2
    - 2 vcpu
    - 1024 RAM
    - 192.168.33.15 VM ip address

## Architecture
![Architecture Diagram](https://raw.githubusercontent.com/rrodolfos/prestashop-nginx-scalable-vagrant-ansible/main/architecture/prestashop_scalable.webp "Architecture Diagram")

## In a nutshell

### shop VM
This VM has all stateful services and a NGINX reverse proxy. So this machine will act as a cloud-ish infrastructure for our stateless prestashop nodes. Services included in this VM are:

  - NGINX as reverse proxy
  - Redis as session handler for php
  - NFS as PrestaShop common web files storage
  - MariaDB as usual
  
> Note: PrestaShop does not use php sessions instead it uses cookies. However, in [How to make PrestaShop scale](https://devdocs.prestashop.com/1.7/scale/) official documentation they does mention Redis to store sessions so there it is. If by any chance you know why please let me know.

### prestashop-{1,2} VMs
These VMs have all stateless PrestaShop services. They contain a web server with php, and some web files. Services included in these VMs are:

  - NGINX as web server
    - Stateful web files are stored in NFS
  - php-fpm
    - Sessions are handled by Redis

## How to build it

### Shop
This VM deploys stateful services for PrestaShop server with mariadb, redis, nfs, nginx and php as follow (by ansible):
  - Install MariaDB server
  - Install NGINX and configure as reverse proxy
  - Install NFS server and configure exports
  - Install and configure Redis

### Prestashop{1,2}
These VMs deploy stateless PrestaShop nodes (servers) with nginx and php as follow (by ansible):
  - Install php
  - Install Redis tools (client)
  - Install MariaDB client
    - Create prestashop database
    - Create prestashop user and its privileges
  - Install NFS client
    - Mount prestashop shared files
  - Install NGINX
    - Download and install prestashop
    - Configure NGINX prestashop server
  - Print shop URL
  - Print prestashop{1,2} URLs
  - Have fun!

### Clone this repository
```
  $ git clone https://github.com/rrodolfos/prestashop-nginx-scalable-vagrant-ansible.git
```

### Change to the cloned repository directory
```
  $ cd prestashop-nginx-scalable-vagrant-ansible
```

### Create vagrant VMs and deploy PrestaShop
To start up the VM
```
  $ vagrant up
```
> Coffee time!. On a MacBook Pro 2015 and 50Mbps bandwidth it took ~15 minutes. Vagrant box (base linux distro) downloading time not included.

### Check VMs
To connect to the VM (ssh)
```
  $ vagrant ssh {shop,prestashop-1,prestashop-2}
```

### Connect to PrestaShop
#### Shop
```
  http://shop.local
```

#### To connect as a customer via web browser
```
  http://shop.local/en/login
```
  `Username:` pub@prestashop.com
  `Password:` 123456789

#### To connect as a administrator (employee) via web browser
```
  http://shop.local/admin56
```
  `Username:` john.doe@foo.foo
  `Password:` 0123456789

### Destroy vagrant VM
To destroy the VM
```
  $ vagrant destroy
```

## Notes
  - Be sure the VM has the package ```acl``` is installed (Ansible should do it for you ;-)
  - To change paths, user names, passwords and prestashop installation values check:
    ```prestashop-nginx-scalable-vagrant-ansible/provisioning/vars/main.yml```
  - When use `$ vagrant ssh`. It sholud have a VM name. Eg:

    ```
    $ vagrant ssh shop
    $ vagrant ssh prestashop-1
    $ vagrant ssh prestashop-2
    ```

  - To show prestashop cookies check: ```http://shop.local/admin56/cookies.php```
  - Please feel free to let me know any question, error, improvement or opinion by email

## Author

> Rodolfo Sauce-Guinand - rrodolfos gmail com