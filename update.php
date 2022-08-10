<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';
        $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
        $harga = isset($_POST['harga']) ? $_POST['harga'] : '';
        $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE produk SET nama_produk = ?, keterangan = ?, harga = ?, jumlah = ? WHERE id = ?');
        $stmt->execute([$nama_produk, $keterangan, $harga, $jumlah, $_GET["id"]]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM produk WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $produk = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$produk) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {    
    exit('Tidak ada nama barang!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Produk #<?=$produk['nama_produk']?></h2>
    <form action="update.php?id=<?=$produk['id']?>" method="post">
    <label for="nama_produk">Nama Produk</label>
        <label for="keterangan">Keterangan</label>
        <input type="text" name="nama_produk" id="nama_produk">
        <input type="text" name="keterangan" id="keterangan">
        <label for="harga">Harga</label>
        <label for="jumlah">Jumlah</label>
        <input type="text" name="harga" id="harga">
        <input type="text" name="jumlah" id="jumlah">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>