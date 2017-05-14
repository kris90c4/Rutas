<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title ?></title>
    </head>
    <body>
        <table class="table">
 
            <thead>
                <tr>
                    <th>
                        Id
                    </th>
                    <th>
                        Nombre
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user)
                {
                ?>
                <tr>
                    <td><?php echo $user["id"] ?></td>
                    <td><?php echo $user["nombre"] ?></td>
                    <td><?php echo $user["apellidos"] ?></td>
                    <td><?php echo $user["correo"] ?></td>
                    <td><?php echo $user["contraseña"] ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </body>
</html>