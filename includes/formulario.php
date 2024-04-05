<main style='display:flex; position: fixed; top: 50%; left: 50%; flex-direction:column; align-items: center; transform: translate(-50%, -50%);'>

    <section>
        <a href="index.php">
            <button>Voltar</button>
        </a>
    </section>

    <h2><?=TITLE?></h2>
    
    <form method="post">

        <div>
            <label>Nome</label>
            <input type="text" name="nome" value="<?=$obUser->nome?>">
        </div>

        <div>
            <label>E-Mail</label>
            <input type="email" name="email" value="<?=$obUser->email?>">
        </div>

        <div>
            <label>Senha</label>
            <input type="password" name="senha" value="<?=$obUser->senha?>">
        </div>

        <div>
            <label>Apelido</label>
            <input type="text" name="apelido" value="<?=$obUser->apelido?>">
        </div>

        <div>
            <label>Perfil</label>
            <div>
                
            <div>
                    <label>
                        <input type="radio" name="perfil" value="2" <?=$obUser->id_perfil_usuario == '2' ? 'checked' : ''?>> Gestor
                    </label>
                </div>
                
                <div>
                    <label>
                        <input type="radio" name="perfil" value="3" <?=$obUser->id_perfil_usuario == '3' ? 'checked' : ''?>> Colaborador
                    </label>
                </div>

            </div>
        </div>

        <div>
            <button type="submit">Enviar</button>
        </div>

    </form>

</main>