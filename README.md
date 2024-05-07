# CS745 Project

## Setup

- Ubuntu 22.04 Server and Desktop images
- Virtualbox NAT network
    - Port forwarding to access from host
- Virtualbox cloning
    - Linked clones to save disk space
    - Make these changes before cloning, so clones have different IPs
        - Add `dhcp-identifier: mac` to the netplan yaml. Refer [this](https://unix.stackexchange.com/a/519220/599466)
    - Also, while cloning, choose: "Generate new MAC addresses..."

- BB and DB setup notes inside `serverA` directory
