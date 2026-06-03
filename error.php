<?php if (defined('__ERROR__') && $showExceptions): ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>FluxCP FR : erreur critique</title>
		<style type="text/css" media="screen">
			body {
				margin: 10px;
				padding: 0;
				font-family: "Lucida Grande", "Lucida Sans", sans-serif;
			}
			
			p {
				font-size: 85%;
			}
			
			pre {
				font-family: Monaco, "Lucida Console", monospace;
			}
			
			.heading {
				font-family: "Gill Sans", "Gill Sans MT", "Lucida Grande", "Lucida Sans", sans-serif;
				font-weight: normal;
				border-bottom: 1px solid #ddd;
			}
			
			.backtrace {
				font-size: 85%;
				border-spacing: 0;
				border-collapse: collapse;
				background-color: #fefefe;
			}
			
			.backtrace th, .backtrace td {
				padding: 5px;
				border: 1px solid #ccc;
			}
			
			.backtrace th {
				background-color: #eee;
			}
		</style>
	</head>
	
	<body>
		<h2 class="heading">Erreur critique</h2>
		
		<p>Une erreur est survenue pendant l’execution de l’application.</p>
		<p>Elle peut etre causee par plusieurs problemes, comme une anomalie applicative.</p>
		<p><strong>Le plus souvent, elle provient toutefois d’une <em>mauvaise configuration</em>.</strong></p>
		
		<h2 class="heading">Details de l’exception</h2>
		<p>Erreur : <strong><?php echo get_class($e) ?></strong></p>
		<p>Message: <em><?php echo nl2br(htmlspecialchars($e->getMessage())) ?></em></p>
		<p>Fichier : <?php echo $e->getFile() ?>:<?php echo $e->getLine() ?></p>
		
		<?php if (count($e->getTrace())): ?>
		<!-- Exception Backtrace -->
		<table class="backtrace">
			<tr>
				<th>Fichier</th>
				<th>Ligne</th>
				<th>Fonction / methode</th>
			</tr>
			<?php foreach ($e->getTrace() as $trace): ?>
			<tr>
				<td><?php echo $trace['file'] ?></td>
				<td><?php echo $trace['line'] ?></td>
				<td><?php echo isset($trace['class']) ? "$trace[class]::$trace[function]" : $trace['function'] ?>()</td>
			</tr>
			<?php endforeach ?>
		</table>
		
		<h2 class="heading">Trace de l’exception</h2>
		<pre><?php echo htmlspecialchars(preg_replace('/PDO->__construct\\((.+?)\\)/', 'PDO->__construct(*hidden*)', $e->getTraceAsString())) ?></pre>
		<?php endif ?>
	</body>
</html>
<?php else: ?>
<h2>Erreur</h2>
<p>Une erreur est survenue pendant le traitement de votre requete.</p>
<p>Veuillez contacter un administrateur : <a href="mailto:<?php echo htmlspecialchars($adminEmail) ?>"><?php echo htmlspecialchars($adminEmail) ?></a></p>
<?php endif ?>
