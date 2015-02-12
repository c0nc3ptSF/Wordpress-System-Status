# Wordpress System Status
Easily display system messages to your visitors.

###Going To Need To Get Your Hands Dirty
It's important to note that this plugin isn't plug n' play. You will need to edit your template files so you can place the system message where ever you want in your theme and then style it. I would suggest placing the required method in a template file that is used on every page, like a header, footer, or sidebar.  
  
 In the future I plan on building in some more robust features that will limit (if not eliminate) the need to edit template files, but honestly I needed a quick solution to a problem I had and when it worked out well I decided to share it on Github.
 
###Quick Instructions
  - Grab the files from Github
  - Extract Directory
  - Put extracted directory in your Wordpress Plugins Directory
  - Activate Plugin
  - Place the following line where you want the system message to show up: <?php global $systemStatus; $systemStatus->systemMessage(); ?>
  - Style however you like.
  - Message type will change the class of the message element.
  - You can select multiple post types to display the message.
  - I'll have a more detailed tutorial on my blog soon.
