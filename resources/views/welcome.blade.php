<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prénoms populaires à Angers</title>
    <link rel="stylesheet" href="style.css">  </head>
<body>
<div class="container">
    <h1>Prénoms populaires à Angers</h1>
    <form action="#">
        <fieldset> <legend>Filtrer par sexe :</legend>
            <input type="radio" name="sexe" value="F" {{$sexe === 'F' ? 'checked' : ''}}> Femme
            <input type="radio" name="sexe" value="M" {{$sexe === 'M' ? 'checked' : ''}}> Homme
        </fieldset>
        <button type="submit">Filtrer</button>
    </form>
    <section class="stats">  <h2>Statistiques</h2>
        <p>Prénom le plus utilisé depuis 1900 : {{$famousName}} ({{$nbOccurence}} fois)</p>
        <p>Prénom le plus utilisé depuis 2015 : {{$famousName2015}} ({{$nbOccurence2015}} fois)</p>
        <p>Prénom le plus utilisé depuis 2023 : {{$famousName2023}} ({{$nbOccurence2023}} fois)</p>
    </section>
    <h2>Les 10 prénoms les plus utilisés depuis 2015</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Prénom</th>
            <th>Nombre d'occurrences</th>
        </tr>
        </thead>
        <tbody>
        @foreach($top10 as $prenom => $nombreOccurrences)
            <tr>
                <td>{{$prenom}}</td>
                <td>{{$nombreOccurrences}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h2>Les 10 prénoms les plus rares depuis 2015</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Prénom</th>
            <th>Nombre d'occurrences</th>
        </tr>
        </thead>
        <tbody>
        @foreach($topRare as $prenom => $nombreOccurrences)
            <tr>
                <td>{{$prenom}}</td>
                <td>{{$nombreOccurrences}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        color: #333;
        margin: 20px; /* Add some margin for better spacing */
    }

    h1, h2 {
        color: #000;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .container {
        background-color: #f5f5f5; /* Light background for the container */
        padding: 20px; /* Add some padding for content */
        border-radius: 5px; /* Add rounded corners for a softer look */
    }

    fieldset {
        border: 1px solid #ccc; /* Add a border for the radio group */
        padding: 10px;
        margin-bottom: 15px;
    }

    legend {
        font-weight: bold;
        margin-bottom: 5px;
    }

    p {
        margin-bottom: 10px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 5px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .stats { /* Style the statistics section */
        margin-bottom: 20px;
    }
</style>
