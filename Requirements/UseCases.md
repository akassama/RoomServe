# Updated Use Cases

###Project: 

RoomServiceOnDemand

### Team

**Developers:** Team 4

- Vladimir Solovev
- Valeria IUrinskaia
- Marvin Rene Lopez Moreno
- Vladimir Semenov

###Actor Description 

| Actor Name  | Description                                                  |
| :---------- | :----------------------------------------------------------- |
| The User    | The User is a dormitory habitant who can order a room cleaning service. |
| The Manager | The Manager is a dormitory manager who receives the cleaning service request. The dormitory manager assigns the order to the Personnel. |

###Glossary 

| Syntax                   | Description                                                  |
| ------------------------ | ------------------------------------------------------------ |
| List of offered services | List of cleaning options available for making an order. The current list can be found at https://hotel.university.innopolis.ru/portal/page/66-article |

###Diagram: RoomServiceOnDemand Use Cases 

#### 1. Create Account 

| Use Case Name   | Create Account                                               |
| --------------- | ------------------------------------------------------------ |
| Actors          | User                                                         |
| Pre-conditions  | The User is willing to use our services                      |
| Flow of events  | 1. The User opens the platform and selects registration.  <br />2. The User fills the required information like first name, last name, email.    <br />3. The User selects a strong password ensured by the System.   <br />4. The User registered in the system |
| Post-conditions | The User got an account to login with.                       |

#### 2. Login 

| Use Case Name   | Login                                                        |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager, User                                                |
| Pre-conditions  | The User or The Manager has an account registered in the system. |
| Flow of events  | 1. The User or The Manager go to the Login page.  <br />2. The User or The Manager type the email.  <br />3. The User or The Manager type the password.  <br />4. The User or The Manager submits the login.  <br />5. The System does authentication.  <br />5.1. If the email and password have been recognized,   then show the homepage.<br />5.2. If the email and password haven’t been   recognized, then show the error message. |
| Post-conditions | The system shows the homepage to the User or the Manager.    |

#### 3. Logout  

| Use Case Name   | Logout                                                       |
| --------------- | ------------------------------------------------------------ |
| Actors          | User, Manager                                                |
| Pre-conditions  | The User and The Manager has an account registered in the system.  <br />The User and The Manager account has been authenticated. |
| Flow of events  | 1. The User or The Manager click the logout button. <br />2. The system does logout. <br />3. The system shows the logout message. |
| Post-conditions | The User or the Manager has been logged out.                 |

#### 4. Check status 

| Use Case Name   | Check status                                                 |
| --------------- | ------------------------------------------------------------ |
| Actors          | User                                                         |
| Pre-conditions  | The User has an account registered in the system.  <br />The User account has been authenticated.  <br />The User already created an order. |
| Flow of events  | 1. The User selects an order.  <br />2. The User receives the corresponding information. |
| Post-conditions | The User sees the current status of the selected order       |

#### 5. Delete Order (User part)  

| Use Case Name   | Delete Order (User part)                                     |
| --------------- | ------------------------------------------------------------ |
| Actors          | User                                                         |
| Pre-conditions  | The User has an account registered in the system.<br />The User has an open order.  <br/>The User account has been authenticated. |
| Flow of events  | 1. The User clicks on the action button.<br />2. The User chooses the delete button. <br />3. The User confirms order deleting. |
| Post-conditions | Order deleted by the User                                    |

#### 6. Delete Order (Manager part) 

| Use Case Name   | Delete Order (Manager part)                                  |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager                                                      |
| Pre-conditions  | The Manager account has been authenticated.                  |
| Flow of events  | 1. The Manager clicks on the action button. <br />2. The Manager chooses the delete button. <br />3. The Manager confirms order deleting. |
| Post-conditions | The system sends an email notification to the user about the removal of the order. The order is deleted by the manager |

#### 7. Send notification  

| Use Case Name   | Send notification                                            |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager, User                                                |
| Pre-conditions  | The User has an account registered in the system.<br />The User account has been authenticated. <br/>The Manager account has been authenticated. |
| Flow of events  | 1. The Manager opens one order. <br />2. The Manager selects the action (Edit/Activate/Approve/ Deactivate/ Delete/ Decline/Cancel).   <br />3. The system sends to the User a email with a notification about action. |
| Post-conditions | The User received the notification created by the Manager.   |

#### 8. Accept Order  

| Use Case Name   | Accept Order                                                 |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager                                                      |
| Pre-conditions  | The Manager account has been authenticated.<br />The User created an order. <br/>The Manager received the User’s order. |
| Flow of events  | 1.The Manager checks the order details. <br />2.The Manager accepts the order. |
| Post-conditions | The order’s status is changed to Accepted. The User received the notification created by the Manager. |

#### 9. Decline Order  

| Use Case Name   | Decline Order                                                |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager, User                                                |
| Pre-conditions  | The Manager account has been authenticated. <br />The User created an order. <br/>The Manager received the User’s order. |
| Flow of events  | 1.The Manager checks an order details.  <br/>2.The Manager initiates declining of the order.   <br />3.The Manager inputs a reason for declining.  <br/>4.The Manager sends declining information to User. |
| Post-conditions | The order’s status is changed to Declined. The User received the notification created by the Manager. |

#### 10. Deactivate Order  

| Use Case Name   | Deactivate Order                                             |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager, User                                                |
| Pre-conditions  | The Manager account has been authenticated. <br />The User created an order. <br/>The Manager received the User’s order. |
| Flow of events  | 1. The Manager checks the order details.  <br />2. The Manager accepts the order. |
| Post-conditions | The order’s status is changed to Accepted. The User received the notification created by the Manager. |

#### Diagram: Detailed “Place Order” Use Case  

#### 11. Enter Apartment No and description 

| Use Case Name   | Enter Apartment No and description                           |
| --------------- | ------------------------------------------------------------ |
| Actors          | User                                                         |
| Pre-conditions  | The User has an account registered in the system. <br />The User account has been authenticated. |
| Flow of events  | 1.The User enters an Apartment No for cleaning. <br />2.The User enters a description for cleaning. |
| Post-conditions | The date and time for cleaning is fulfilled.                 |

#### 12. Select time and date 

| Use Case Name   | Select time and date                                         |
| --------------- | ------------------------------------------------------------ |
| Actors          | User                                                         |
| Pre-conditions  | The User has an account registered in the system.<br />The User account has been authenticated. |
| Flow of events  | 1. The User initiates order creation. <br />2. The User selects a date for cleaning. <br />3. The User selects time for cleaning. |
| Post-conditions | The date and time for cleaning is fulfilled.                 |

#### 13. Select cleaning options 

| Use Case Name   | Select cleaning options                                      |
| --------------- | ------------------------------------------------------------ |
| Actors          | User                                                         |
| Pre-conditions  | The User has an account registered in the system. <br />The Manager created at least one cleaning option. |
| Flow of events  | 1. The User selects needed cleaning options from the list of offered services. |
| Post-conditions | Preferable cleaning options are fulfilled.                   |

#### 14. Select payment options 

| Use Case Name   | Select cleaning options                                      |
| --------------- | ------------------------------------------------------------ |
| Actors          | User                                                         |
| Pre-conditions  | The User has an account registered in the system. <br />The Manager created at least one payment option. |
| Flow of events  | 1. The User selects needed payment options from the list of payment options. |
| Post-conditions | Preferable payment options are fulfilled.                    |

####Diagram: Detailed “Manage list of offered services” use case 

#### 15. Add cleaning option 

| Use Case Name   | Add cleaning option                                          |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager                                                      |
| Pre-conditions  | The Manager account has been authenticated.                  |
| Flow of events  | 1.The Manager initiates the addition of the cleaning option. <br />2.The Manager input the cleaning option name. <br />3.The Manager input the short description. <br />4.The Manager input the price. |
| Post-conditions | The cleaning option data is added.                           |

#### 16. Update cleaning option 

| Use Case Name   | Update cleaning option                                       |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager                                                      |
| Pre-conditions  | The Manager account has been authenticated.<br/>The Manager created at least one cleaning option. |
| Flow of events  | 1.The Manager selects the cleaning option from an existing set. <br />2.The Manager edits the cleaning option name. <br />3.The Manager edits the short description. <br />4.The Manager edits the price. |
| Post-conditions | The cleaning option data is updated.                         |

#### 17. Remove cleaning option 

| Use Case Name   | Remove cleaning option                                       |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager                                                      |
| Pre-conditions  | The Manager account has been authenticated.<br/>The Manager created at least one cleaning option. |
| Flow of events  | 1.The Manager selects the cleaning option from an existing set. <br />2.The Manager initiates removing of cleaning option. <br />3.The Manager removes the cleaning option. |
| Post-conditions | The cleaning option data is removed.                         |

####Diagram: Detailed “Manage list of payment options” use case 

#### 18. Add payment option 

| Use Case Name   | Add payment option                                           |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager                                                      |
| Pre-conditions  | The Manager account has been authenticated.                  |
| Flow of events  | 1.The Manager initiates the addition of the payment option. <br />2.The Manager input the payment option name. <br />3.The Manager input the short description. |
| Post-conditions | The payment option data is added.                            |

#### 19. Update payment option 

| Use Case Name   | Update cleaning option                                       |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager                                                      |
| Pre-conditions  | The Manager account has been authenticated.<br/>The Manager created at least one payment option. |
| Flow of events  | 1.The Manager selects the payment option from an existing set. <br />2.The Manager edits the payment option name. <br />3.The Manager edits the short description. |
| Post-conditions | The payment option data is updated.                          |

#### 20. Remove payment option 

| Use Case Name   | Remove payment option                                        |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager                                                      |
| Pre-conditions  | The Manager account has been authenticated.<br/>The Manager created at least one payment option. |
| Flow of events  | 1.The Manager selects the payment option from an existing set. <br />2.The Manager initiates removing of payment option. <br />3.The Manager removes the payment option. |
| Post-conditions | The payment option data is removed.                          |

####Diagram: Detailed “Manage list of personnel options” use case 

#### 21. Add personnel option 

| Use Case Name   | Add personnel option                                         |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager                                                      |
| Pre-conditions  | The Manager account has been authenticated.                  |
| Flow of events  | 1.The Manager initiates the addition of the personnel option. <br />2.The Manager input the personnel option name. <br />3.The Manager input the short description. |
| Post-conditions | The personnel option data is added.                          |

#### 22. Update personnel option 

| Use Case Name   | Update personnel option                                      |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager                                                      |
| Pre-conditions  | The Manager account has been authenticated.<br/>The Manager created at least one personnel option. |
| Flow of events  | 1.The Manager selects the personnel option from an existing set. <br />2.The Manager edits the personnel option name. <br />3.The Manager edits the short description. |
| Post-conditions | The personnel option data is updated.                        |

#### 23. Remove personnel option 

| Use Case Name   | Remove personnel option                                      |
| --------------- | ------------------------------------------------------------ |
| Actors          | Manager                                                      |
| Pre-conditions  | The Manager account has been authenticated.<br/>The Manager created at least one personnel option. |
| Flow of events  | 1.The Manager selects the personneloption from an existing set. <br />2.The Manager initiates removing of personnel option. <br />3.The Manager removes the personnel option. |
| Post-conditions | The personnel option data is removed.                        |

####
