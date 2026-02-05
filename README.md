# DWC Filter Device Type

### Adds the option to filter for device type in dynamic web content.

## Setting up the right requirements 

## Requirements for this release
> [!TIP]
> Other releases of this plugin may cover different Mautic versions!
- Mautic 5.x (minimum 5.1)
- PHP X.X or higher

> [!IMPORTANT]
> If you are on Mautic 5 older than 5.2.7 (which you should not be!), please make sure to install changes from PR https://github.com/mautic/mautic/pull/13226 using the "patch" mechanism (otherwise plugin will not work)

## Installation
### Composer
This plugin can be installed through composer.
### Manual Installation
Alternatively, it can be installed manually, following the usual steps:
- Download the plugin
- Unzip to the Mautic `plugins` directory
- Rename folder to `LeuchtfeuerDwcDeviceTypeBundle`
- In the Mautic backend, go to the `Plugins` page as an administrator
- Click on the `Install/Upgrade Plugins` button to install the Plugin.
OR
- If you have shell access, execute `php bin\console cache:clear` and `php bin\console mautic:plugins:reload` to install the plugins.


## How to use this plugin?
- After enabling plugin, create new Dynamic Content. 
- Make this DWC not campaign based on the right-hand side *->* give him **slot_name** and fill content. 
- Now go to filters section, which appeared after setting this DWC to not campaign based and add filter "Device Type" where you can select operator(including, excluding, empty, not empty) and choose which device types you want to be filtered
- Save and close
- Go to Landing Pages *->* select already existing page or create new and add in builder DWC by writing {dwc=**slot_name**}
- Save and exit

## Change log
### Changes in 1.1.0
1) Configuration:
- Primary parameter (dropdown from unique contact fields?)
- Enforce matching secondary parameter (dropdown from contact fields / default = NONE? Or different UI?)
2) Additionally, a change to the logic
- If the passed primary parameter already exists in leads AND "Enforce Matching Secondary Parameter" is set, then check that same parameter. If it does not match, abort (with log entry).
3) Write an audit log entry
- User/source name = "mcontrol"
### All changes
- https://github.com/Leuchtfeuer/mautic-DwcDeviceType-bundle/releases

## Future Ideas

## Sponsoring & Commercial Support
We are continuously improving our plugins. If you are requiring priority support or custom features, please contact us at mautic-plugins@leuchtfeuer.com.
## Get Involved
Feel free to open issues or submit pull requests on [GitHub](#). Follow the contribution guidelines in `CONTRIBUTING.md`.”
## Credits

## Author
Leuchtfeuer Digital Marketing GmbH
Please raise any issues in GitHub.
For all other things, please email mautic-plugins@Leuchtfeuer.com
## License
“This plugin is licensed under the MIT License. See the `LICENSE` file for more details.”
## Resources / Further Readings
