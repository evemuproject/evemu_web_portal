<h1>1. Download the client</h1><br>
<a href="#">Windows client</a><br>

<h1>2. Download BluePatcher</h1><br>
<a href="https://github.com/stschake/blue_patcher/raw/f16ba3ceb3c439fd42f5b3fe0abf241ca60828bc/blue_patcher.exe">Blue patcher download from Github</a><br>

<h1>3. Patch blue.dll</h1><br>
Open BluePatcher<br><center><img style="behavior:url(border-radius.htc);border-radius: 5px;" src="images/installationstep2.png"></center><br>
If it does not detects automatically the game folder click the button "wrong?" and select your EVE game folder/bin/blue.dll file. Now click patch. If everything went OK you should see something like this:<br>
<center><img style="behavior:url(border-radius.htc);border-radius: 5px;" src="images/installationstep3.png"></center><br>
<h1>4. Edit game files</h1><br>
Go to your EVE folder and open the file <strong>start.ini</strong>.<br>
Change the line:
<pre>
server=Tranquility
</pre>
to:
<pre>
server=<?php echo $GAME_Server; ?>
</pre><br>
Now open the file <strong>common.ini</strong>, in the same folder and change:
<pre>
cryptoPack=CryptoAPI
</pre>
to:
<pre>
cryptoPack=Placebo
</pre>