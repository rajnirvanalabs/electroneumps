# ElectroneumPS
A Prestashop addon  for accepting Electroneum (ETN)

Compatible with the latest stable version of Prestashop (1.6.x).

## Dependancies
This plugin is rather simple but there are a few things that need to be set up before hand.

* A web server! Ideally with the most recent versions of PHP and mysql

* An Electroneum wallet. Offline Wallet or CLI Wallet would be better since they have private view key for transaction validation. You can find the official wallet [here](https://electroneum.com/), Offline Wallet [here](https://downloads.electroneum.com) and CLI Wallet [here](https://github.com/electroneum/electroneum-pool#1-downloading--installing)

* [Prestashop](https://prestashop.com)
Prestashop is open source e-commerce engine to run your own shop and this Electroneum plugin

## Step 1: Activating the plugin
* Downloading: First of all, you will need to download the module. You can download the latest release as a .zip file from https://github.com/rajnirvanalabs/electroneumps If you wish, you can also download the latest source code from GitHub. This can be done with the command `git clone https://github.com/rajnirvanalabs/electroneumps.git` or can be downloaded as a zip file from the GitHub web page.

* Unzip the file electroneumps-master.zip if you downloaded the zip from the master page [here](https://github.com/rajnirvanalabs/electroneumps).

* Upload the module and activate it. You can refer the official documentation [here](https://addons.prestashop.com/en/content/21-how-to)

## Step 2 : Use your wallet address and connect to an electroneum daemon

### Option 1: Running a full node yourself

To do this: start the electroneum daemon on your server and leave it running in the background. This can be accomplished by running `./electroneumd` inside your electroneum downloads folder. The first time that you start your node, the electroneum daemon will download and sync the entire electroneum blockchain. This can take several hours and is best done on a machine with at least 4GB of ram, an SSD hard drive (with at least 40GB of free space), and a high speed internet connection.
You can refer the official documentation for running full node from [here](https://github.com/electroneum/electroneum) and for wallet rpc from [here](https://github.com/electroneum/electroneum-pool#1-downloading--installing).

### Option 2: Connecting to a remote node
The easiest way to find a remote node to connect to is to visit [ElectroneumPool](https://github.com/electroneum/electroneum-pool#pools-using-this-software) and use one of the nodes offered which supports json_rpc. `Eg. https://etn.mymininghub.com/json_rpc port 445`

`Note: You must run your JSON RPC on the host server of Prestashop against your wallet`

### Setup your  electroneum wallet-rpc

* Setup a electroneum wallet using the electroneum-wallet-cli tool. If you do not know how to do this you can learn about it at [https://github.com/electroneum/electroneum-pool](https://github.com/electroneum/electroneum-pool#1-downloading--installing)
You can checkout the electroneum wallet commands from [here](https://github.com/electroneum/electroneum/wiki/Wallet-Commands-(CLI))


* Start the Wallet RPC and leave it running in the background. This can be accomplished by running `electroneum-wallet-rpc --wallet-file /path/to/wallet/file --password walletPassword --rpc-bind-port 26969 --disable-rpc-login` where "/path/to/wallet/file" is the wallet file for your electroneum wallet. If you wish to use a remote node you can add the `--daemon-address` flag followed by the address of the node. `--daemon-address etn.mymininghub.com:443` for example.

## Step 4: Setup Electroneum Gateway in Prestashop
* Navigate to the "Modules and Services" panel in the Prestashop sidebar and identify `Electroneum Payments` module and click on `configure`.
* Update `Electroneum Wallet Address` and `Wallet RPC IP/HOST`
* Save the changes and you are good to go.
