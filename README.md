# DWC Filter Device Type

### Adds the option to filter for device type in dynamic web content.

## Setting up the right requirements 

- Mautic 5.0.0 or higher
- PHP 8.0 or higher
- Before installing plugin, please make sure to install changes from PR https://github.com/mautic/mautic/pull/13226, otherwise plugin will not work

## Installation
- Plugin has to be saved within plugins/LeuchtfeuerDwcDeviceTypeBundle/
- After completed installing of plugin, the cache has to be cleared (php bin/console c:c )
- Reload plugins page and press "Install/Upgrade Plugins" button
- Now plugin appeared, open it and publish by switching to button "Yes" under "Published" label and save configuration

## How to use this plugin?
- After enabling plugin, create new Dynamic Content. 
- Make this DWC not campaign based on the right-hand side *->* give him **slot_name** and fill content. 
- Now go to filters section, which appeared after setting this DWC to not campaign based and add filter "Device Type" where you can select operator(including, excluding, empty, not empty) and choose which device types you want to be filtered
- Save and close
- Go to Landing Pages *->* select already existing page or create new and add in builder DWC by writing {dwc=**slot_name**}
- Save and exit

## Author
Leuchtfeuer Digital Marketing GmbH

mautic@Leuchtfeuer.com
