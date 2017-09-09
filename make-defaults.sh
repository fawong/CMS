#!/bin/sh

set -e
set -x

SETTINGS_FILE="settings.php"
EXTENSION="sample"

cp --verbose $SETTINGS_FILE $SETTINGS_FILE.$EXTENSION

sed --in-place "s/\$db_username = '.*';/\$db_username = 'db_username';/" $SETTINGS_FILE.$EXTENSION
sed --in-place "s/\$db_password = '.*';/\$db_password = 'db_password';/" $SETTINGS_FILE.$EXTENSION
sed --in-place "s/\$db_name = '.*';/\$db_name = 'db_name';/" $SETTINGS_FILE.$EXTENSION
sed --in-place "s/\$ftp_username = '.*';/\$ftp_username = 'ftp_username';/" $SETTINGS_FILE.$EXTENSION
sed --in-place "s/\$ftp_password = '.*';/\$ftp_password = 'ftp_password';/" $SETTINGS_FILE.$EXTENSION
sed --in-place "s/\$settings\['files_path'\] = '.*';/\$settings['files_path'] = '\/path\/to\/store\/files\/';/" $SETTINGS_FILE.$EXTENSION
sed --in-place "s/\$settings\['email'\] = '.*';/\$settings['email'] = 'email@example.com';/" $SETTINGS_FILE.$EXTENSION
sed --in-place "s/\$settings\['replyemail'\] ='.*';/\$settings['replyemail'] ='noreply@example.com';/" $SETTINGS_FILE.$EXTENSION
sed --in-place "s/\$settings\['logo'\] = '.*';/\$settings['logo'] = 'http:\/\/www.example.com\/logo.png';/" $SETTINGS_FILE.$EXTENSION
sed --in-place "s/\$settings\['url'\] = '.*';/\$settings['url'] = 'http:\/\/www.example.com\/path\/to\/cms';/" $SETTINGS_FILE.$EXTENSION
sed --in-place "s/\$settings\['recaptcha_public_key'\] = '.*';/\$settings['recaptcha_public_key'] = 'PUBLIC_KEY_HERE';/" $SETTINGS_FILE.$EXTENSION
sed --in-place "s/\$settings\['recaptcha_private_key'\] = '.*';/\$settings['recaptcha_private_key'] = 'PRIVATE_KEY_HERE';/" $SETTINGS_FILE.$EXTENSION

mysqldump --no-data notacms > mysql.sql
