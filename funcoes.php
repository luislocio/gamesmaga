<?php
session_start();

# ---------- DATABASE ----------
define("DSN", "mysql");
define("SERVIDOR", "localhost");
define("USUARIO", "luislocio");
define("SENHA", "73917391");
define("BANCODEDADOS", "gamesmaga");

function conectar()
{
  try {
    $conn = new PDO(DSN.':host='.SERVIDOR.';dbname='.
    BANCODEDADOS, USUARIO, SENHA);
    return $conn;
  } catch (PDOException $e) {
    echo ''.$e->getMessage();
  }
}


# ---------- ALERTAS ----------
function console_log($data)
{
  echo '<script>';
  echo 'console.log('. json_encode($data) .')';
  echo '</script>';
}

// A função showAlert foi adicionada no arquivo footer.php,
// exceto nas paginas de login, que não possuem footers.
function showAlert(){
  if (!empty($_SESSION['mensagem'])) {
    echo '<script>';
    echo 'alert('. json_encode($_SESSION['mensagem']) .')';
    echo '</script>';

    unset($_SESSION['mensagem']);
  }
}

// As mensagens relacionadas a controle de acesso são definidas antes do redirecionamento.
// As mensagens relacionadas ao CRUD são definidas dentro das funções salvar, editar e excluir.
function acessoRestrito(){
  $_SESSION["mensagem"] = "Acesso Restrito";
}

function necessarioLogin(){
  $_SESSION["mensagem"] = "Necessário realizar login.";
}

function necessarioFrete(){
  $_SESSION["mensagem"] = "Necessário calcular o frete.";
}

function loginInvalido(){
  $_SESSION["mensagem"] = "Usuario ou senha inválidos.";
}

# ---------- CLIENTES ----------
function buscarCliente($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, email, login, senha, nomecompleto, cpf, celular, telefonefixo, sexo, datanascimento, cep, endereco, numero, complemento, referencia, bairro, cidade, estado from CLIENTES where id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function editarCliente($cliente)
{
  $conn = conectar();
  $stmt = $conn->prepare('update CLIENTES set email=:email, login=:login, nomecompleto=:nomecompleto, cpf=:cpf, celular=:celular, telefonefixo=:telefonefixo, sexo=:sexo, datanascimento=:datanascimento, cep=:cep, endereco=:endereco, numero=:numero, complemento=:complemento, referencia=:referencia, bairro=:bairro, cidade=:cidade, estado=:estado where id = :id');
  $stmt->bindParam(':id', $cliente['id']);
  $stmt->bindParam(':email', $cliente['email']);
  $stmt->bindParam(':login', $cliente['login']);
  $stmt->bindParam(':nomecompleto', $cliente['nomeCompleto']);
  $stmt->bindParam(':cpf', $cliente['cpf']);
  $stmt->bindParam(':celular', $cliente['celular']);
  $stmt->bindParam(':telefonefixo', $cliente['telefoneFixo']);
  $stmt->bindParam(':sexo', $cliente['sexo']);
  $stmt->bindParam(':datanascimento', $cliente['dataNascimento']);
  $stmt->bindParam(':cep', $cliente['cep']);
  $stmt->bindParam(':endereco', $cliente['endereco']);
  $stmt->bindParam(':numero', $cliente['numero']);
  $stmt->bindParam(':complemento', $cliente['complemento']);
  $stmt->bindParam(':referencia', $cliente['referencia']);
  $stmt->bindParam(':bairro', $cliente['bairro']);
  $stmt->bindParam(':cidade', $cliente['cidade']);
  $stmt->bindParam(':estado', $cliente['estado']);
  if ($stmt->execute()) {
    console_log("Cliente alterado com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

function excluirCliente($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("DELETE from CLIENTES where id=:id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  if ($stmt->execute()) {
    console_log("Cliente removido com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

function listarClientes()
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, email, login, senha, nomecompleto, cpf, celular, telefonefixo, sexo, datanascimento, cep, endereco, numero, complemento, referencia, bairro, cidade, estado from CLIENTES order by nomecompleto");
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function salvarCliente($cliente)
{
  $conn = conectar();
  $stmt = $conn->prepare("INSERT INTO CLIENTES(email, login, senha, nomecompleto, cpf, celular, telefonefixo, sexo, datanascimento, cep, endereco, numero, complemento, referencia, bairro, cidade, estado) VALUES(:email, :login, :senha, :nomecompleto, :cpf, :celular, :telefonefixo, :sexo, :datanascimento, :cep, :endereco, :numero, :complemento, :referencia, :bairro, :cidade, :estado)");
  $stmt->bindParam(':email', $cliente['email']);
  $stmt->bindParam(':login', $cliente['login']);
  $stmt->bindParam(':senha', $cliente['senha']);
  $stmt->bindParam(':nomecompleto', $cliente['nomeCompleto']);
  $stmt->bindParam(':cpf', $cliente['cpf']);
  $stmt->bindParam(':celular', $cliente['celular']);
  $stmt->bindParam(':telefonefixo', $cliente['telefoneFixo']);
  $stmt->bindParam(':sexo', $cliente['sexo']);
  $stmt->bindParam(':datanascimento', $cliente['dataNascimento']);
  $stmt->bindParam(':cep', $cliente['cep']);
  $stmt->bindParam(':endereco', $cliente['endereco']);
  $stmt->bindParam(':numero', $cliente['numero']);
  $stmt->bindParam(':complemento', $cliente['complemento']);
  $stmt->bindParam(':referencia', $cliente['referencia']);
  $stmt->bindParam(':bairro', $cliente['bairro']);
  $stmt->bindParam(':cidade', $cliente['cidade']);
  $stmt->bindParam(':estado', $cliente['estado']);
  if ($stmt->execute()) {
    console_log("Cliente inserido com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

# ---------- DESENVOLVEDORAS ----------
function buscarDesenvolvedora($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nm_desenvolvedora from DESENVOLVEDORAS where id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function editarDesenvolvedora($desenvolvedora)
{
  $conn = conectar();
  $stmt = $conn->prepare('update DESENVOLVEDORAS set nm_desenvolvedora=:nm_desenvolvedora where id = :id');
  $stmt->bindParam(':nm_desenvolvedora', $desenvolvedora['desenvolvedora']);
  $stmt->bindParam(':id', $desenvolvedora['id']);
  if ($stmt->execute()) {
    console_log("Desenvolvedora alterada com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

function excluirDesenvolvedora($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("DELETE from DESENVOLVEDORAS where id=:id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  if ($stmt->execute()) {
    console_log("Desenvolvedora removida com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

function listarDesenvolvedoras()
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nm_desenvolvedora from DESENVOLVEDORAS order by nm_desenvolvedora");
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function salvarDesenvolvedora($desenvolvedora)
{
  $conn = conectar();
  $stmt = $conn->prepare("INSERT INTO DESENVOLVEDORAS(nm_desenvolvedora) VALUES(:nm_desenvolvedora)");
  $stmt->bindParam(':nm_desenvolvedora', $desenvolvedora['desenvolvedora']);
  if ($stmt->execute()) {
    console_log("Desenvolvedora inserida com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

# ---------- DISTRIBUIDORAS ----------
function buscarDistribuidora($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nm_distribuidora from DISTRIBUIDORAS where id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function editarDistribuidora($distribuidora)
{
  $conn = conectar();
  $stmt = $conn->prepare('update DISTRIBUIDORAS set nm_distribuidora=:nm_distribuidora where id = :id');
  $stmt->bindParam(':nm_distribuidora', $distribuidora['distribuidora']);
  $stmt->bindParam(':id', $distribuidora['id']);
  if ($stmt->execute()) {
    console_log("Distribuidora alterada com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

function excluirDistribuidora($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("DELETE from DISTRIBUIDORAS where id=:id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  if ($stmt->execute()) {
    console_log("Distribuidora removida com sucesso!");
  } else {
    console_log($stmt->errorInfo());

    return "erro! ";
  }
}

function listarDistribuidoras()
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nm_distribuidora from DISTRIBUIDORAS order by nm_distribuidora");
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function salvarDistribuidora($distribuidora)
{
  $conn = conectar();
  $stmt = $conn->prepare("INSERT INTO DISTRIBUIDORAS(nm_distribuidora) VALUES(:nm_distribuidora)");
  $stmt->bindParam(':nm_distribuidora', $distribuidora['distribuidora']);
  if ($stmt->execute()) {
    console_log("Distribuidora inserida com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

# ---------- FUNCIONARIOS ----------
function buscarFuncionario($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, login, senha, acesso from FUNCIONARIOS where id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function editarFuncionario($funcionario)
{
  $conn = conectar();
  $stmt = $conn->prepare('update FUNCIONARIOS set login=:login, acesso=:acesso where id = :id');
  $stmt->bindParam(':login', $funcionario['login']);
  $stmt->bindParam(':acesso', $funcionario['acesso']);
  $stmt->bindParam(':id', $funcionario['id']);
  if ($stmt->execute()) {
    console_log("Funcionario alterado com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

function excluirFuncionario($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("DELETE from FUNCIONARIOS where id=:id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  if ($stmt->execute()) {
    console_log("Funcionario removido com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

function listarFuncionarios()
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, login, senha, acesso from FUNCIONARIOS order by acesso");
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function salvarFuncionario($funcionario)
{
  $conn = conectar();
  $stmt = $conn->prepare("INSERT INTO FUNCIONARIOS(login, senha, acesso) VALUES(:login, :senha, :acesso)");
  $stmt->bindParam(':login', $funcionario['login']);
  $stmt->bindParam(':senha', $funcionario['senha']);
  $stmt->bindParam(':acesso', $funcionario['acesso']);
  if ($stmt->execute()) {
    console_log("Funcionario inserido com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}
# ---------- GENEROS ----------
function buscarGenero($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nm_genero from GENEROS where id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function editarGenero($genero)
{
  $conn = conectar();
  $stmt = $conn->prepare('update GENEROS set nm_genero=:nm_genero where id = :id');
  $stmt->bindParam(':nm_genero', $genero['genero']);
  $stmt->bindParam(':id', $genero['id']);
  if ($stmt->execute()) {
    console_log("Genero alterado com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

function excluirGenero($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("DELETE from GENEROS where id=:id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  if ($stmt->execute()) {
    console_log("Genero removido com sucesso!");
  } else {
    console_log($stmt->errorInfo());

    return "erro! ";
  }
}

function listarGeneros()
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nm_genero from GENEROS order by nm_genero");
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function salvarGenero($genero)
{
  $conn = conectar();
  $stmt = $conn->prepare("INSERT INTO GENEROS(nm_genero) VALUES(:nm_genero)");
  $stmt->bindParam(':nm_genero', $genero['genero']);
  if ($stmt->execute()) {
    console_log("Genero inserida com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

# ---------- JOGOS ----------
# ==== CRUD ====
function buscarJogo($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nome, ano, desenvolvedora, distribuidora, plataforma, genero, preco, url, descricao from JOGOS where id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function editarJogo($jogo)
{
  if (!stripos($jogo['url'], '.')) {
    $jogoAlterado=buscarJogo($jogo['id']);
    $jogo['url'] = $jogoAlterado['url'];
  }


  $conn = conectar();
  $stmt = $conn->prepare('update JOGOS set nome=:nome, ano=:ano, desenvolvedora=:desenvolvedora, distribuidora=:distribuidora, plataforma=:plataforma, genero=:genero, preco=:preco, url=:url, descricao=:descricao where id = :id');
  $stmt->bindParam(':id', $jogo['id']);
  $stmt->bindParam(':nome', $jogo['nome']);
  $stmt->bindParam(':ano', $jogo['ano']);
  $stmt->bindParam(':desenvolvedora', $jogo['desenvolvedora']);
  $stmt->bindParam(':distribuidora', $jogo['distribuidora']);
  $stmt->bindParam(':plataforma', $jogo['plataforma']);
  $stmt->bindParam(':genero', $jogo['genero']);
  $stmt->bindParam(':preco', $jogo['preco']);
  $stmt->bindParam(':url', $jogo['url']);
  $stmt->bindParam(':descricao', $jogo['descricao']);
  if ($stmt->execute()) {
    console_log("Jogo alterada com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

function excluirJogo($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("DELETE from JOGOS where id=:id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  if ($stmt->execute()) {
    console_log("Jogo removido com sucesso!");
  } else {
    console_log($stmt->errorInfo());

    return "erro! ";
  }
}

function listarJogos()
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nome, ano, desenvolvedora, distribuidora, plataforma, genero, preco, url, descricao from JOGOS order by nome");
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function salvarJogo($jogo)
{
  $conn = conectar();
  $stmt = $conn->prepare("INSERT INTO JOGOS(nome, ano, desenvolvedora, distribuidora, plataforma, genero, preco, url, descricao) VALUES(:nome, :ano, :desenvolvedora, :distribuidora, :plataforma, :genero, :preco, :url, :descricao)");
  $stmt->bindParam(':nome', $jogo['nome']);
  $stmt->bindParam(':ano', $jogo['ano']);
  $stmt->bindParam(':desenvolvedora', $jogo['desenvolvedora']);
  $stmt->bindParam(':distribuidora', $jogo['distribuidora']);
  $stmt->bindParam(':plataforma', $jogo['plataforma']);
  $stmt->bindParam(':genero', $jogo['genero']);
  $stmt->bindParam(':preco', $jogo['preco']);
  $stmt->bindParam(':url', $jogo['url']);
  $stmt->bindParam(':descricao', $jogo['descricao']);
  if ($stmt->execute()) {
    console_log("Jogo inserido com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

# ==== EXTRAS ====
function corDaBorda($fabricante)
{
  switch ($fabricante) {
    case 'Sony':
    return "primary";
    break;
    case 'Microsoft':
    return "success";
    break;
    case 'Nintendo':
    return "danger";
    break;
    default:
    return "dark";
    break;
  }
}

function limpaString($str)
{
  $str = preg_replace('/[áàãâä]/ui', 'a', $str);
  $str = preg_replace('/[éèêë]/ui', 'e', $str);
  $str = preg_replace('/[íìîï]/ui', 'i', $str);
  $str = preg_replace('/[óòõôö]/ui', 'o', $str);
  $str = preg_replace('/[úùûü]/ui', 'u', $str);
  $str = preg_replace('/[ç]/ui', 'c', $str);
  // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
  $str = preg_replace('/[^a-z0-9]/i', '_', $str);
  $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
  return $str;
}

# ==== FILTROS ====
function filtroPorGenero($idGenero)
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nome, ano, desenvolvedora, distribuidora, plataforma, genero, preco, url, descricao from JOGOS where genero = :idGenero order by nome");
  $stmt->bindParam(':idGenero', $idGenero);
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function filtroPorPlataforma($idPlataforma)
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nome, ano, desenvolvedora, distribuidora, plataforma, genero, preco, url, descricao from JOGOS where plataforma = :idPlataforma order by nome");
  $stmt->bindParam(':idPlataforma', $idPlataforma);
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function barraDeBusca($texto)
{
  $termoDaBusca = "%".$texto."%";
  $conn = conectar();
  $stmt = $conn->prepare("SELECT JOGOS.id, nome, ano, desenvolvedora, distribuidora, plataforma, genero, preco, url, descricao FROM JOGOS JOIN PLATAFORMAS ON PLATAFORMAS.id = JOGOS.plataforma JOIN GENEROS ON GENEROS.id = JOGOS.genero WHERE PLATAFORMAS.nm_plataforma LIKE :termoDaBusca OR GENEROS.nm_genero LIKE :termoDaBusca OR JOGOS.nome LIKE :termoDaBusca order by nome");
  $stmt->bindParam(':termoDaBusca', $termoDaBusca);
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}


# ---------- PEDIDOS ----------#

function criarPedido($idCliente, $itens, $frete){
  $conn = conectar();
  try {
    $conn->beginTransaction();
    $data = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("INSERT INTO PEDIDOS(id_cliente, dt_compra, vl_frete) VALUES(:idCliente, :dtCompra, :vlFrete)");
    $stmt->bindParam(':idCliente', $idCliente);
    $stmt->bindParam(':dtCompra', $data);
    $stmt->bindParam(':vlFrete', $frete);
    if ($stmt->execute()) {
      $idPedido =  $conn->lastInsertId();
      inserirItens($idPedido, $itens, $conn);
      console_log("Pedido inserido com Sucesso");
    } else {
      console_log($stmt->errorInfo());
      return "erro! ";
    }
    $conn->commit();
  } catch( PDOExecption $e ) {
    $conn->rollback();
    console_log("Error!: " . $e->getMessage());
  }
}

function listarPedidos(){
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, id_cliente, dt_compra, dt_pagamento, vl_frete FROM PEDIDOS");
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function listarPedidosPorCliente($idCliente){
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, dt_compra, dt_pagamento, vl_frete FROM PEDIDOS WHERE id_cliente=:idCliente");
  $stmt->bindParam(':idCliente', $idCliente);
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function inserirItens($idPedido,$itens,$conn){
  try {

    foreach ($itens as $item) {
      for ($i=0; $i < $item['quantidade']; $i++) {
        $stmt = $conn->prepare("INSERT INTO ITENS_DO_PEDIDO(id_pedido, id_jogo, vl_produto) VALUES(:idPedido, :idJogo, :valorProduto)");
        $stmt->bindParam(':idPedido', $idPedido);
        $stmt->bindParam(':idJogo', $item['id']);
        $stmt->bindParam(':valorProduto', $item['preco']);
        if ($stmt->execute()) {
          console_log("Itens inseridos com Sucesso");
        } else {
          console_log($stmt->errorInfo());
          return "erro! ";
        }
      }

    }

  } catch( PDOExecption $e ) {
    console_log("Error!: " . $e->getMessage());
  }
}

function listarItens($idPedido){
  $conn = conectar();
  $stmt = $conn->prepare("SELECT ITENS_DO_PEDIDO.id_jogo, JOGOS.nome, PLATAFORMAS.nm_plataforma, ITENS_DO_PEDIDO.vl_produto FROM ITENS_DO_PEDIDO JOIN JOGOS ON ITENS_DO_PEDIDO.id_jogo = JOGOS.id JOIN PLATAFORMAS ON JOGOS.plataforma = PLATAFORMAS.id where ITENS_DO_PEDIDO.id_pedido=:idPedido");
  $stmt->bindParam(':idPedido', $idPedido);
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function quantidadeDeItens($idPedido, $idItem){
  $conn = conectar();
  $stmt = $conn->prepare("SELECT COUNT(id) as quantidade FROM ITENS_DO_PEDIDO WHERE id_pedido=:idPedido and id_jogo=:idJogo");
  $stmt->bindParam(':idPedido', $idPedido);
  $stmt->bindParam(':idJogo', $idItem);
  $stmt->execute();
  $quantidade = $stmt->fetch(PDO::FETCH_ASSOC);
  return $quantidade['quantidade'];
}

#
# implementa funcao de calculo de preços e prazos
# para serviços dos correios
#
if( !function_exists( 'calculaFrete' ))
{
  function calculaFrete(
    $cod_servico, /* codigo do servico desejado */
    $cep_origem,  /* cep de origem, apenas numeros */
    $cep_destino, /* cep de destino, apenas numeros */
    $peso,        /* valor dado em Kg incluindo a embalagem. 0.1, 0.3, 1, 2 ,3 , 4 */
    $altura,      /* altura do produto em cm incluindo a embalagem */
    $largura,     /* altura do produto em cm incluindo a embalagem */
    $comprimento, /* comprimento do produto incluindo embalagem em cm */
    $valor_declarado='0' /* indicar 0 caso nao queira o valor declarado */
  ){

    $cod_servico = strtoupper( $cod_servico );
    if( $cod_servico == 'SEDEX10' ) $cod_servico = 40215 ;
    if( $cod_servico == 'SEDEXACOBRAR' ) $cod_servico = 40045 ;
    if( $cod_servico == 'SEDEX' ) $cod_servico = 40010 ;
    if( $cod_servico == 'PAC' ) $cod_servico = 41106 ;

    # ###########################################
    # Código dos Principais Serviços dos Correios
    # 41106 PAC sem contrato
    # 40010 SEDEX sem contrato
    # 40045 SEDEX a Cobrar, sem contrato
    # 40215 SEDEX 10, sem contrato
    # ###########################################

    $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$cep_origem."&sCepDestino=".$cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valor_declarado."&sCdAvisoRecebimento=n&nCdServico=".$cod_servico."&nVlDiametro=0&StrRetorno=xml";

    $xml = simplexml_load_file($correios);

    $_arr_ = array();
    if($xml->cServico->Erro == '0'):
      $_arr_['codigo'] = $xml -> cServico -> Codigo ;
      $_arr_['valor'] = $xml -> cServico -> Valor ;
      $_arr_['prazo'] = $xml -> cServico -> PrazoEntrega .' Dias' ;
      // return $xml->cServico->Valor;
      return $_arr_ ;
    else:
      return false;
    endif;
  }
}
#
# fim da funcao
#


# ---------- PLATAFORMAS ----------
function buscarPlataforma($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nm_plataforma, fabricante from PLATAFORMAS where id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function editarPlataforma($plataforma)
{
  $conn = conectar();
  $stmt = $conn->prepare('update PLATAFORMAS set nm_plataforma=:nm_plataforma, fabricante=:fabricante where id = :id');
  $stmt->bindParam(':nm_plataforma', $plataforma['plataforma']);
  $stmt->bindParam(':fabricante', $plataforma['fabricante']);
  $stmt->bindParam(':id', $plataforma['id']);
  if ($stmt->execute()) {
    console_log("Plataforma alterada com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}

function excluirPlataforma($id)
{
  $conn = conectar();
  $stmt = $conn->prepare("DELETE from PLATAFORMAS where id=:id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  if ($stmt->execute()) {
    console_log("Plataforma removida com sucesso!");
  } else {
    console_log($stmt->errorInfo());

    return "erro! ";
  }
}

function listarPlataformas()
{
  $conn = conectar();
  $stmt = $conn->prepare("SELECT id, nm_plataforma, fabricante from PLATAFORMAS order by nm_plataforma");
  $stmt->execute();
  $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $retorno;
}

function salvarPlataforma($plataforma)
{
  $conn = conectar();
  $stmt = $conn->prepare("INSERT INTO PLATAFORMAS(nm_plataforma, fabricante) VALUES(:nm_plataforma, :fabricante)");
  $stmt->bindParam(':nm_plataforma', $plataforma['plataforma']);
  $stmt->bindParam(':fabricante', $plataforma['fabricante']);
  if ($stmt->execute()) {
    console_log("Plataforma inserida com sucesso!");
  } else {
    console_log($stmt->errorInfo());
    return "erro! ";
  }
}
