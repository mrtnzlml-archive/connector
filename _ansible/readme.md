ansible-playbook deploy.yml

ansible-playbook --inventory-file=_ansible/production _ansible/deploy.yml [-t deploy]

--check     (dry run)
--verbose



ansible webservers -i _ansible/production -m setup
ansible webservers -i _ansible/production -m setup -a 'filter=ansible_distribution'
ansible all -i _ansible/production -m ping
ansible all -i _ansible/production -a "uname -r"
