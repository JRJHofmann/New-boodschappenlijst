<?php require 'partials/header.php' ?>
<?php require 'partials/nav.php' ?>

    <table>
        <tr>
            <th>Product</th>
            <th>Aantal</th> 
            <th>Prijs</th>
            <th>Subtotaal</th>
        </tr>
        <?php foreach ($boodschappen as $boodschap): ?>
            <tr>
                <td class="tekst"><?php echo htmlspecialchars($boodschap["name"]); ?></td>
                <td class="numbers"><?php echo htmlspecialchars($boodschap["number"]); ?></td>
                <td class="numbers"><?php echo htmlspecialchars(number_format($boodschap["price"], 2)); ?></td>
                <td class="numbers"><?php echo htmlspecialchars(number_format($boodschap["number"] * $boodschap["price"], 2)); ?></td>
            </tr>
            <?php endforeach ?>
            <tr>
                <td colspan="3" style ="text-align: left;"><strong>Totale kosten</strong></td>
                <td class="numbers"><?php echo htmlspecialchars(number_format($totaal_prijs, 2)); ?></td>
            </tr>
    </table>

<?php require 'partials/footer.php' ?>