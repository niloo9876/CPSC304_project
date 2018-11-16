<?php include "../template/header.php"; ?>

    <h2>Add a Game to OnSaleList</h2>

    <form method="post">
        <label for="Name">Game's ID</label>
        <input type="number" name="GID" id="GID">
        <label for="EventIndex">EventIndex</label>
        <input type="number" name="EventIndex" id="EventIndex">
        <label for="salePrice">Sale Price</label>
        <input type="number" name="salePrice" id="salePrice">
        <label for="startDate">Start date of sale</label>
        <input type="date" name="startDate" id="startDate">
        <label for="endDate">End date of sale</label>
        <input type="date" name="endDate" id="endDate">


    </form>

    <a href="../index.php">Back to home</a>

