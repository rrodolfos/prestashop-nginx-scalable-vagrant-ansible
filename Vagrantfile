Vagrant.configure("2") do |config|

  config.vm.define "shop" do |config|
    config.vm.network "private_network", ip: "192.168.33.13"
    config.vm.hostname = "shop"

    config.vm.provider "virtualbox" do |vb|
      vb.memory = "1024"
      vb.cpus = "2"
    end
  end

  config.vm.define "prestashop-1" do |config|
    config.vm.network "private_network", ip: "192.168.33.14"
    config.vm.hostname = "prestashop-1"

    config.vm.provider "virtualbox" do |vb|
      vb.memory = "1024"
      vb.cpus = "2"
    end
  end

  config.vm.define "prestashop-2" do |config|
    config.vm.network "private_network", ip: "192.168.33.15"
    config.vm.hostname = "prestashop-2"

    config.vm.provider "virtualbox" do |vb|
      vb.memory = "1024"
      vb.cpus = "2"
    end
  end

  config.vm.provision "ansible" do |ansible|
    ansible.playbook = "provisioning/playbook.yml"
    ansible.compatibility_mode = "2.0"
    # ansible.verbose = "vvv"
    ansible.groups = {
      "prestashop" => [
        "prestashop-1",
        "prestashop-2"
      ],
    }
  end

  config.vm.box = "debian/bullseye64"
  config.vm.synced_folder "share", "/srv/share"
  #config.vm.synced_folder "../data", "/vagrant_data", type: "nfs"

end
