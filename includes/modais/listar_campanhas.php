<body>
    <form method="GET">
    <div id="fade" class="hide"></div>
            <div id="modal" class="hide">
                <div class="cabeçalho-modal">
                    <h2 class="titulo-modal">Campanhas:</h2>
                </div>
                <div class="modal-body">
                    <div class="conteudo-modal">
                        <?php
                            use \App\Entity\Campanha;
                            $obModal = new Campanha;
                            $info = $obModal->visualizar();
                            foreach ($info as $campanha){
                                ?>
                                <div class="container-campanha">
                                    <div class="conteudo-campanha">
                                        <div class="campanha-texto">
                                            <div class="conjunto-nome">
                                                <h3 class="apresenta-nome">Nome da Campanha:</h3>
                                                <h3 class="nome-campanha"><?=$campanha['nome_campanha']?></h3>
                                            </div>
                                            <div class="conjunto-datas">
                                                <div class="inicio-conjunto">
                                                    <h3 class="apresenta-data">Data Início:</h3>
                                                    <h3 class="inicio-campanha"><?=date("d/m/Y", strtotime($campanha['data_inicio']))?></h3>
                                                </div>
                                                <h2 class="separa-data">-</h2>
                                                <div class="final-conjunto">
                                                    <h3 class="apresenta-data">Data Término:</h3>
                                                    <h3 class="termino-campanha"><?=date("d/m/Y", strtotime($campanha['data_final']))?></h3>
                                                </div>
                                            </div>
                                        </div>
                            
                                    </div>

                                </div>

                           <?php };

                        ?>
                    </div>
                    <div class="botao-fecha">
                        <button id="close-modal" class="custom-btn btn-1">Fechar</button>
                    </div>                 
                </div>
            </div>
<script src="../js/modal.js"></script>
</body>
</html>