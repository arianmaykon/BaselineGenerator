Just a simple app to help configuration management tasks, for now, baseline generation, with test and release baselines already been generated. Sorry for the stupid name :)


#BaselineGenerator
================================================================================

##Português

(Trabalho em andamento...)

Como usar/rodar (Linux/Ubuntu)

- Clone o repositório para a pasta htdocs/www do seu Apache HTTP Server executando os comandos abaixo no terminal:
	```shell
	cd /var/www/
	git clone https://github.com/arianmaykon/BaselineGenerator.git
	```
- Depois execute:
	cd BaselineGenerator
	./symfony project:permissions
	cp config/databases.yml-dist config/databases.yml
	cp apps/frontend/config/app.yml-dist apps/frontend/config/app.yml
- Edite o arquivo config/databases.yml para configurar a sua conexão com o banco de dados:
	Opcional - Você pode configurar a conexão com o banco de dados com o comando a seguir (altere a palavra 'mysql' para qualquer outro SGBD de sua opção, consulte a documentação do Symfony/Doctrine):
		./symfony configure:database "mysql:host=YOURSERVER;dbname=blgenerator" dbuser dbpassword
- Para que seja criado o database/schema e as tabelas, execute:
	./symfony doctrine:build --all --and-load --no-confirmation
- Agora você pode acessar a aplicação com a URL http://localhost/BaselineGenerator/web/frontend_dev.php/baseline e cadastrar seus dados, veja algumas explicações dos dados mais relevantes das entidades utilizadas:
	Parameter:
		JiraBaseUrl: a URL raiz do Jira da sua empresa.
		SvnBaseUrl: a URL raiz do SVN da sua empresa.
		FtpHost: URL do servidor FTP.
	System:
		JiraComponent: Nome do componente do Jira criado para gerir o sistema, será utilizado em algumas convenções na geração, como por exemplo o caminho de cópia do SVN para a geração de tags e a hierarquia de tags (Eu sei que está bem confuso, uma m*rd*, mas será melhorado).
		FtpPath: Caminho no FTP onde será realizado o upload dos arquivos de entrega.
		SourceFolderCompressionType: tipo de compressão utilizado para os fontes, tar.gz ou zip.
	Baseline:
		System (FK System): O sistema/software que se deseja gerar baseline, cadastrado na tela System, algumas informações dele serão utilizados no processo de geração da baseline, como o componente do Jira e outros dados.
		Name: O nome da baseline, será utilizado na criação da versão no Jira.
		Type: Classificação da baseline, o processo de geração varia entre esses dois tipos, mais detalhes em breve.
		Issues: Chaves das issues no Jira que irão fazer parte desta baseline, separadas por vírgula (,). Na geração, serão recuparados os seus tipos e descrições, que serão usados para sugerir a descrição da baseline/version, usados nos e-mails de baseline e disponibilização de demanda e num futuro próximo, na geração do release notes para as issues de Release.
- Após cadastrados as informações explicadas, é necessário, por hora, configurar manualmente alguns dados para a plena geração das baselines, edite o arquivo lib/BaselineProcess.php, localizando por volta da linha 50, as variáveis abaixo, a serem preenchidas com o explicado [Lembre-se, a ser melhorado :) ]:
	$networkUser     = Nome do usuário, utilizado para a autenticação no Jira, SVN e envio de e-mails.
	$jiraPassword    = Senha do Jira do usuário informado.
	$svnPassword     = Senha do SVN do usuário informado.
- Ainda no mesmo arquivo, localize e edite o conteúdo abaixo (por volta da linha 82), trocando o valor JIRA_PROJECT_KEY pela chave do projeto no Jira, as letra que precedem todas as issues:
    $jiraClient = new JiraAPISoapClient($parameter->getJiraBaseUrl(),
        'JIRA_PROJECT_KEY', $networkUser, $jiraPassword);
- Configurado as informações acima, podemos solicitar a geração das baselines cadastradas, executando o comando abaixo, substituindo o ID pelo ID do registro de baseline que se deseja gerar, o mesmo pode ser obtido na tela de gestão das baselines:
	./symfony generatebaseline ID




CONVENÇÕES / PREMISSAS

Como observado no arquivo BaselineProcess.php, o processo de geração, conta atualmente, com algumas premissas, a saber:
- Na criação da tag do SVN, será criado em /tags um diretório com o mesmo nome da Baseline que foi solicitada a geração, dentro deste diretório, haverá um diretório "codigo", que para ele será copiado o diretório dos fontes do sistema, que espera-se ser o diretório de mesmo nome do componente do Jira, e que deve existir em /trunk/implementacao/aplicacoes/.




O QUE SERÁ FEITO?

O processo de geração irá se comportar conforme abaixo:
	- Será consultado o Jira para obter as descrições e tipos das issues informadas na baseline;
	- Será criado no Jira a versão com o mesmo nome da Baseline;
	- Será criado uma tag no SVN com o mesmo nome da Baseline, em um diretório com o mesmo nome do componente do Jira (System). Ex.: /tags/mysystem/baseline_teste_01/ e /tags/mysystem/baseline_teste_01/codigo/;
	- Será copiado para a pasta código da "tag criada", o diretório do sistema no trunk, conforme explanado na sessão "CONVENÇÕES / PREMISSAS";
	SE A BASELINE FOR DE TESTE:
		- [TO DO] Serão adicionados na tag gerada os artefatos de testes relacionados com as issues que estão na baseline que se está gerando;
	SE A BASELINE FOR DE RELEASE:
		- Será efetuado o checkout da tag criada (/tags/mysystem/baseline_teste_01/);
		- [TO DO] Será gerado o release notes baseado nas informações da baseline que se está gerando;
		- [TO DO] Serão adicionados a tag o release notes e demais artefatos necessários para a release;
		- Será feito o export (svn export) do diretório que foi feito o checkout;
		- Serão compactados os fontes do sistema presente na tag (/tags/mysystem/baseline_teste_01/codigo/mysystem/) no formato configurado no cadastro do sistema (tar.gz ou zip);
		- Será compactado o diretório exportado e tratado, no formato 7-zip (/tags/mysystem/baseline_teste_01/);
		- Será realizado o upload do arquivo 7-zip gerado;
		- Será enviado o e-mail de disponibilização de demandas;
	- Será feito o release da versão criada no Jira;
	- [TO DO] Serão atualizados os fontes nos servidores de teste/homologação;
	- Será enviado o e-mail da baseline;




--------------------------------------------------------------------------------

##English

(Work in progress...)

How to use (Linux/Ubuntu)

- Clone the repo to your apache "htdocs" folder running the above commands in the terminal:
	cd /var/www/
	git clone https://github.com/arianmaykon/BaselineGenerator.git
- After the clone operation ends, execute:
	cd BaselineGenerator
	./symfony project:permissions
	cp config/databases.yml-dist config/databases.yml
	cp apps/frontend/config/app.yml-dist apps/frontend/config/app.yml
- Edit the config/databases.yml file to configure your database connection:
- Opcional - You can set the database connection with the command (change the mysql to another DBMS if you desire): ./symfony configure:database "mysql:host=YOURSERVER;dbname=blgenerator" dbuser dbpassword
- To create the database schema and tables, run: ./symfony doctrine:build --all --and-load --no-confirmation
- Now you can access the app and enter with your data, see some explanation of the more relevanta data:
	Parameter:
		JiraBaseUrl: your's company Jira's root URL
		SvnBaseUrl: your's company SVN's root URL
		FtpHost: your's company FTP's URL
	System:
		JiraComponent: Jira's component name for the software you want to generate baselines, will be used for some convensions too, as SVN default path to copy and tag use (yeah, i know, crappy but will be improved)
		SourceFolderCompressionType: the compression type used to the source files, tar.gz or zip
	Baseline:
		System (FK System): the system/software for wich you want to generate a baseline, some info from it will be used in the generation, as the Jira component and other data
		Name: the baseline's name, and also the Jira version wich will be created on the generation process
		Type: baseline's classification, the generation process it's different between them
		Issues: Jira's issues keys, wich will be searched to fetch their types and summaries. This info is used in the suggested baselines description and used in the e-mails, in a near future will be present in the release notes as well
- To complete...