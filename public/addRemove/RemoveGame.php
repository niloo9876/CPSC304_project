<?php include "../template/header.php"; ?>

    <h2>Remove a Game</h2>

    <form method="post">
        <label for="Genre">Genre</label>
        <input type="text" name="Genre" id="Genre">
        <label for="Name">Name</label>
        <input type="text" name="Name" id="Name">
        <label for="GID">GID</label>
        <input type="number" name="GID" id="GID">
        <label for="Price">Price</label>
        <input type="number" name="Price" id="Price">
        <label for="DevName">Developer Name</label>
        <input type="text" name="DevName" id="DevName">
        <label for="SalePrice">Sale Price</label>
        <input type="number" name="SalePrice" id="SalePrice">
        <input type="submit" name="submit" value="Submit">
    </form>

    <a href="../index.php">Back to home</a>

<?php include "../template/footer.php"; ?>