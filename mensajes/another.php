<table >
                    <thead>
                        <tr>
                            <th>Nombre Empleado</th>
                            <th>Fecha Nac.</th>
                            <th>Sexo</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>E-mail</th>
                            <th>Sucursal</th>
                            <th>Turno</th>
                            <th>Depto.</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($usuario =$infoQuery->fetch_assoc()){?>
                            <tr>
                                <td><?php echo $usuario['Apellido_p'] .' '. $usuario['Apellido_m'] .' '. $usuario['Nombre']; ?> </td>
                                <td><?php echo $usuario['Fecha_nac']; ?> </td>
                                <td><?php echo $usuario['Sexo']; ?></td>
                                <td><?php echo $usuario['Calle'] .' Col: '. $usuario['Colonia'] .' C.P '. $usuario['CP'] .', '. $usuario['Entidad']; ?></td>
                                <td><?php echo $usuario['Telefono']; ?></td>
                                <td><?php echo $usuario['Email']; ?></td>
                                <td><?php echo $usuario['Sucursal']; ?></td>
                                <td><?php echo $usuario['Turno']; ?></td>
                                <td><?php echo $usuario['Departamento']; ?></td>
                                <td><a href="edit-empleado.php?id=<?php echo $usuario['Id_empleado']; ?>">Editar</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>