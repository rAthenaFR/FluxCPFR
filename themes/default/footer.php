<?php if (!defined('FLUX_ROOT')) exit; ?>
							</td>
							<td bgcolor="#f5f5f5"></td>
						</tr>

						<tr>
							<td>
								<img src="<?php echo $this->themePath('img/content_bl.gif') ?>" style="display: block" alt="" />
							</td>
							<td bgcolor="#f5f5f5"></td>
							<td>
								<img src="<?php echo $this->themePath('img/content_br.gif') ?>" style="display: block" alt="" />
							</td>
						</tr>
					</table>
				</td>

				<!-- Espacement entre le contenu et la fin horizontale de page -->
				<td style="padding: 10px"></td>
			</tr>

			<?php if (Flux::config('ShowCopyright')): ?>
			<tr>
				<td colspan="3"></td>
				<td id="copyright">
					<p>
						<strong>
							Propulsé par
							<a href="https://github.com/rathena/FluxCP" target="_blank" rel="noopener noreferrer">FluxCP</a>
						</strong>
					</p>
				</td>
				<td></td>
			</tr>
			<?php endif ?>

			<?php if (Flux::config('ShowRenderDetails')): ?>
			<tr>
				<td colspan="3"></td>
				<td id="info">
					<p>
						Page générée en <strong><?php echo round(microtime(true) - __START__, 5) ?></strong> seconde(s).
						Nombre de requêtes exécutées : <strong><?php echo (int)Flux::$numberOfQueries ?></strong>.
						<?php if (Flux::config('GzipCompressOutput')): ?>
							Compression Gzip : <strong>activée</strong>.
						<?php endif ?>
					</p>
				</td>
				<td></td>
			</tr>
			<?php endif ?>

			<?php if (count(Flux::$appConfig->get('ThemeName', false)) > 1): ?>
			<tr>
				<td colspan="3"></td>
				<td align="right">
					<span>
						Thème :
						<select name="preferred_theme" onchange="updatePreferredTheme(this)">
							<?php foreach (Flux::$appConfig->get('ThemeName', false) as $themeName): ?>
							<option value="<?php echo htmlspecialchars($themeName) ?>"<?php if ($session->theme == $themeName) echo ' selected="selected"' ?>>
								<?php echo htmlspecialchars($themeName) ?>
							</option>
							<?php endforeach ?>
						</select>
					</span>

					<form action="<?php echo $this->urlWithQs ?>" method="post" name="preferred_theme_form" style="display: none">
						<input type="hidden" name="preferred_theme" value="" />
					</form>
				</td>
				<td></td>
			</tr>
			<?php endif ?>
		</table>
	</body>
</html>