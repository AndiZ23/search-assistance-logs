# search-assistance-logs
A search interface (implemented with Bing Search API) for a User Research on two different kinds of search assistance tools. 
###### There were 8 participants in the User Research; 4 tasks during each study session. 

### Functionalities:
#### Participant.html & SelectTasks.php

_Used in the actual sessions of the user study. The input participant ID and the task ID will be used for deciding which type of the search assistance (and for which task) to be shown on the search assistance widget._

1. Allow users to input the assigned participant's ID

2. Allow users to begin each task by clicking the task buttion.

#### BingSearch.php
_The search interface with a widget on the right to display the search asssitance._

1. Allow users to launch a query and show 10 search results from Bing API (fetched by **getSearchResult.php**). 

2. Provide the widget for showing the search assistance data from **Assistance.php**.

#### Assistance.php
_Show the search assistance data for the "assistance" widget on **BingSearch.php**._

1. Decide which type of the search assistance to show for the task according to the participant ID and the task ID that inputted from **Participant.html** and **SelectTasks.php**

#### Mouselog.js
_To record the web logs using jQuery+AJAX techniques._

1. Track key and mouse events on the search interface and the search asssistance.

2. With the jQuery's post method, log those events into the database (MariaDB, MySQL), which processed by **writeLogs2db.php**.
---
*NOTE: For security purposes, this repository doesn't include a db connect file (I'm not showing my password in the public XD), and I erased the Bing API Key as well (which's already expired anyway).*
