<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TiKO HT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.0/css/bulma.css"/>
</head>
<body>

<section class="hero is-medium is-primary is-bold">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">Tietokantaohjelmointi</h1>
            <h2 class="subtitle">Harjoitustyö</h2>
            <?php if (isset($_SESSION['nimi'])) : ?>
                <h3 class="subtitle"><?php echo $_SESSION['nimi']; ?></h3>
            <?php endif; ?>
        </div>
    </div>
</section>
<div class="tabs is-centered">
    <ul>
        <li><a href="/">Etusivu</a></li>
    </ul>
</div>

<section class="section">
    <div class="container">
