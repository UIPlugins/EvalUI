# EvalUI
PocketMine-MP plugin which allows you to execute arbitrary code using forms. Use this on production servers!

# How to use?

1. Run command /eval
2. Enter in code you want to execute

If you're idot, this might crash the server, however I've put in a try catch to try to stop it from crashing the server.
The only way I've been able to cause crash so far is using undefined variables. The only variables defined are $server and $sender
which both should work exactly as expected.

Bonus

This also works in the console ;)
