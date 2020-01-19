<div>
    <h1>Validações</h1>

    <div>
        <?php
            foreach ($res as $value) {
                echo "
                    <div style=\"background: #fbb; color: #a22; border: 1px solid #d88; padding: 18px 20px; margin: 5px;\">
                        $value
                    </div>
                ";
            }
        ?>
    </div>
</div>