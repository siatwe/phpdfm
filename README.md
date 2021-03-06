# PHPDFM
## PHP .dotfile manager.
Actually only written for my own amusement and because I can really use it. I know that there are enough dotfile managers already, but I really only need a lightweight application. The configuration is done via a file named config.ini in the root folder of the aadm directory. First the config.ini must be adapted, here the exact paths to the dotfiles repository and the name of the JSON file are given. Also the command to install packages:

For example:

### config.ini
```ini
[locations]
dotfilesDir=~/.dotfiles
json=files.json

[executables]
installation=sudo pacman -S --needed
```
### files.json
The actual files and directories to be managed are specified in a JSON file in the root of the dotfiles repository. This the syntax:
```json
{
  "ApplicationName": {
    "requirements": [
      "app1",
      "app2",
      "app3",
    ],
    "files": [
      "/path/to/file/file.rc"
    ],
    "dirs": [
      "/path/to/complete/dir"
    ]
  }
}
```
* _requirements_: Which other applications does the program need to be executed correctly and desired?
* _files_: Here you specify the exact path to a configuration file.
* _dirs_: If complete folders are to be managed, the exact file path is specified here.

### Example files.json
```json
{
  "ApplicationName": {
    "requirements": [
      "app1",
      "app2",
      "app3",
    ],
    "files": [
      "/path/to/file/file.rc"
    ],
    "dirs": [
      "/path/to/complete/dir"
    ]
  }
}
```
If the configuration files of the application do not have whole folders or requirements, you can leave these fields empty.
## Installation
The code of the application is completely written in PHP, there is no binary executable file but a start script in the root directory. The name of the start script is: phpdfm.php. This is an executable script. If this is not the case, it can be made executable with:
```bash
chmod a+x phpdfm.php
```
The script can then theoretically be executed from any location. To use it globally, you can use the following solution:
Create a script with the following content and any name:
```bash
#! /bin/bash
cd /path/to/phpdfm && php phpdfm.php $1
```
Save the file, make it executable and move it to /usr/local/bin/fileName:
```bash
sudo chmod a+x phpdfm
sudo mv phpdfm /usr/local/bin/phpdfm
```
## How to use?
Create a folder named .dotfiles in the home folder or the desired directory given in the config.ini.
### Update
```bash
phpdfm #or
phpdfm update
```
This command without arguments or the update argument copies all specified configuration files and directories to the given dotfiles directory. A folder will be created for each application.
### Install
```bash
phpdfm install
```
Install all dotfiles.
### Fresh
```bash
phpdfm fresh
```
Install all dotfiles and package requirements.
### Help
```bash
phpdfm help
```
## TODO
- Check if dirs are identical before updating
- Refactoring: Create Read class for initial loading config files
- Create JSON config for loading a script before and after updating/installing
- Add changed files to commit message
- Simplifying Execute class methods
- Creating example dotfiles repository

## Links
- [My dotfiles](https://github.com/siatwe/.dotfiles)

## License
   GNU General Public License, version 2 or later.
