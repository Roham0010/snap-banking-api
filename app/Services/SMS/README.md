## To add a new SMS service:

-   Create a new file in this directory
-   It should implement the SMSServiceInterface
-   Add the api key to services.sms.{servicename} and use it in the service file
-   Add it to the SMSServiceProvider to be handled

### To change default SMS service change the services.sms.default

### To change sms messages look into config/sms_messages
