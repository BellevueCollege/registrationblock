[![emoji-log](https://cdn.rawgit.com/ahmadawais/stuff/ca97874/emoji-log/flat-round.svg)](https://github.com/ahmadawais/Emoji-Log/)

# Registration Block
A new, laravel-ly application that allows users to check if they have blocks on their college account.
This application serves as a simple front end for the [Data API](https://github.com/bellevuecollege/data-api), pulling data from the `student` endpoint.

## Dependencies
This project requires access to the following resources: 
1. Access to the [BC Data API](https://github.com/bellevuecollege/data-api)
2. [SimpleSAMLphp](https://simplesamlphp.org/) must be installed and configured on the same server on which this project is installed.

## Notes on Local Development
If you would like to develop this in an environment without SimpleSAMLphp available (as this is difficult to set up locally), you can unhook the SimpleSAMLphp middleware in `app/Http/Kernal.php`, and then define the username you would like to pull data for in the StudentInfo.loadUserInfo model.

Adding something like `$username = 'student.test';` as the first thing inside the `loadUserInfo` class should do it.




