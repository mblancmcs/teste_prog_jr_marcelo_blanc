# Instalação (utilizando o xampp)

1. Clonar o repositório no diretório "htdocs";
2. Copiar a pasta "valida_login_prog_jr_marcelo_blanc" para o diretório anterior ao chamado "htdocs";
3. Ao clonar o repositório, o arquivo no formato "sql" estará lá, com o nome: "db_teste_marcelo_blanc.sql", bastando apenas criar um banco de dados com o mesmo nome e importar esse arquivo de formato "sql".

## Acesso:
Usuário: admin
Senha: 1234

## Observações:

1. No canto superior direito tem 2 botões, o mais a direita é o de sair, e o da esquerda é para entrar em contato comigo.
2. Após fazer um cadastro, reparar que aparecerá o cadastro realizado na tabela abaixo, e no final de cada linha / cadastro terá 2 botões para atualizar ou deletar esse cadastro.

## Consideração em relação ao Sistema Operacional para testar o sistema:

1. Caso use o macOS para testar o mesmo, recomendo que tenha atenção aos comentários do final da função "deletarCadastro()" do script "bd_queries.php"; além dos comentários no final do script "crud_pessoas.php". Pois o sistema foi testado nos dois sistemas operacionais, e para que não dê um Fatal Error no Windows, o sistema foi projetado priorizando esse sistema operacional (Windows); caso teste no macOS, segundo os meus testes, só não aparecerá um tratamento de um erro na página principal do sistema (home.php).
