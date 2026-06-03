<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Vendeurs</h2>

<?php if ($vendings): ?>
    <?php echo $paginator->infoText() ?>
    <table class="horizontal-table">
        <thead>
            <tr>
                <th><?php echo $paginator->sortableColumn('id', 'ID vendeur') ?></th>
                <th> <?php echo $paginator->sortableColumn('char_name', 'Nom du vendeur') ?></th>
                <th>Titre</th>
                <th><?php echo $paginator->sortableColumn('map', 'Carte') ?></th>
                <th>X</th>
                <th>Y</th>
                <th>Genre</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendings as $vending): ?>
                <tr>
                    <td width="50" align="right"  style="">
                        <?php if ($auth->actionAllowed('vending', 'viewshop')): ?>
                            <a href="<?php echo $this->url('vending', 'viewshop', array("id" => $vending->id)); ?>"><?php echo $vending->id; ?></a>
                        <?php else: ?>
                            <?php echo $vending->id ?>
                        <?php endif ?>
                    </td>
                    <td style="font-weight:bold;"> <?php echo $vending->char_name; ?></td>
                    
                    <td>
                       <img src="<?php echo $this->iconImage(671) ?>?nocache=<?php echo rand() ?>" />
                      <?php if ($auth->actionAllowed('vending', 'viewshop')): ?>
                            <a href="<?php echo $this->url('vending', 'viewshop', array("id" => $vending->id)); ?>"><?php echo htmlspecialchars($vending->title); ?></a>
                        <?php else: ?>
                            <?php echo htmlspecialchars($vending->title) ?>
                        <?php endif ?>
                    </td>
                      
                    <td  style="color:blue;">
                      <?php echo $vending->map ?>
                    </td>
                    
                    <td>
                      <?php echo $vending->x ?>
                    </td>
                    
                    <td>
                      <?php echo $vending->y ?>
                    </td>
                    
                     <td>
                      <?php echo $vending->sex ?>
                    </td>
                   
                </tr>

            <?php endforeach ?>
        </tbody>
    </table>
    <?php echo $paginator->getHTML() ?>
<?php else: ?>
    <p>Aucun vendeur trouvé. <a href="javascript:history.go(-1)">Retour</a>.</p>
<?php endif ?>
