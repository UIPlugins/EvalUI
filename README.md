# EvalUI
PocketMine-MP plugin which allows you to execute arbitrary code using forms. Use this on production servers!

# How to use?

1. Run the command /eval
2. Enter in code you want to execute

Note: When executing via the console you need to add the code as arguments.

# Predefined variables

$this is this plugin, EvalUI.
$s is the sender, you.
$srv is the server.

The short variables are intentional; forms limit the amount of characters you're able to type.

# Note

This plugin *should* not crash your server due to typos made by the user.
If you find a way to crash the server that is purely a user input error, feel free to report it and we'll add in another catch to stop the crash.