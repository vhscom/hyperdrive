<h1 align="center">
  <a href="http://hyperdrive.vhs.codeberg.page"><img src="https://codeberg.org/vhs/hyperdrive/blob/master/logo.png" alt="Hyperdrive plugin for WordPress" title="Hyperdrive - The fastest way to load pages in WordPress" width="888"></a>
  <span style="clip: rect(1px, 1px, 1px, 1px); clip-path: polygon(0px 0px, 0px 0px,0px 0px, 0px 0px); position: absolute !important; white-space: nowrap; height: 1px; width: 1px; overflow: hidden;">Hyperdrive</span>
</h1>

<p align="center">
  <a href="https://packagist.org/packages/vhs/hyperdrive"><img src="https://img.shields.io/packagist/v/vhs/hyperdrive.svg?style=flat-square" alt="Packagist"></a>
  <a href="https://php.net/"><img src="https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square" alt="PHP"></a>
  <a href="https://wordpress.com/"><img src="https://img.shields.io/badge/wordpress-%3E%3D%204.6-0087BE.svg?style=flat-square" alt="WordPress"></a>
  <a href="https://travis-ci.org/vhs/hyperdrive"><img src="https://img.shields.io/travis/vhs/hyperdrive.svg?style=flat-square" alt="Travis"></a>
  <a href="https://codecov.io/gh/vhs/hyperdrive"><img src="https://img.shields.io/codecov/c/github/vhs/hyperdrive.svg?style=flat-square" alt="Codecov"></a>
</p>

<h4 align="center">O meio mais rápido de carregar páginas no WordPress</h4>

<p align="center"><em>Hyperdrive é um plugin do WordPress que aumenta a performance do seu utilizando <a href="https://fetch.spec.whatwg.org/">padrões Web modernos</a>. Com base em testes iniciais do Hyperdrive <a href="https://hackernoon.com/putting-wordpress-into-hyperdrive-4705450dffc2">demonstrou</a> uma redução de 200 a 300% da latência percebida no tema Twenty Seventeen.</em></p>

<p align="center">
  Traduções:
  <a href="docs/README_ru.md">Pу́сский</a>,
  <a href="docs/README_es-419.md">Español</a>
  <a href="docs/README_pt-br.md">Brazilian Portuguese</a>
</p>

## Como funciona?

Hyperdrive utiliza uma tecnica de performance conhecida como [Fetch Injection](https://hackcabin.com/post/managing-async-dependencies-javascript/) disponível em [diversos navegadores](http://caniuse.com/#search=fetch). Fetch Injection é alimentado pelo [Fetch](https://github.com/whatwg/fetch), uma moderna substituição do Ajax.

## Instalação

Diversas opções de instalação estão disponíveis. Escolha uma que melhor atenda ao seu nível de habilidade e fluxo de trabalho desejado.

### Sargento

Para instalar o plugin manualmente, simplesmente:

1. Envie o arquivo `hyperdrive.php` para a pasta `/wp-content/plugins/`,
1. Ative o plugin em *Plugins* no seu WordPress.

### Tenente

Para instalar e gerenciar o [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) a partir do diretório de instalação do WordPress:

    composer require vhs/hyperdrive:1.0.x-dev

O comando acima irá baixar a versão beta do Hyperdrive sob o controle de versão e instalará diretamente no diretório `/wp-content/plugins`. O comando `composer update` irá atualizar o plugin.

### Comandante

A única coisa aqui que você poderá não reconhecer é isso [`rupa/z`](https://github.com/rupa/z/):

```shell
ssh user:pass@wordpressbox.tld
z plugins
curl -O https://raw.githubusercontent.com/vhs/hyperdrive/master/src/hyperdrive.php
wp plugin activate hyperdrive
```

## Itens a fazer antes da versão de candidatos 1.0.0

- [ ] Somente retirar os arquivos da fila (dequeue scripts) se [a lista de navegadores compativeis com Fetch](http://caniuse.com/#search=fetch) for compativeis com navegadores antigos.
- [ ] Integrar os comportamentos de localização [como mostrado aqui](https://gist.github.com/vhs/64e8380010e43a526fb9c9ee511fad17#file-functions-php-L507).
- [ ] Teste com alguns temas diferentes e bugs abertos e necessários.

## Contribuindo

Centenas de milhares de individuos e usuários confiam no WordPress todos os dias para consumir e compartilhar informações online. Por esse motivo, a Hyperdrive possui requisitos rigorosos para contribuições de código.

E, embora a Hyperdrive possa ter uma barra alta de qualidade, não deixe que isso impeça você de fazer contribuições. Nós aceitamos todas as pessoas.

Sempre que possível, os proprietários de projetos, colaboradores e contribuidores devem abraçar os [valores do Agile Manifesto](https://pragdave.me/blog/2014/03/04/time-to-kill-agile.html):

> - **Os individuos e as interações** sobre Processos e Ferramentas
> - **Software de Trabalho** sobre Documentação Abrangente
> - **Colaboração do Cliente** sobre Negociação de Contratos, e
> - **Respondendo à Mudança** sobre Como Seguir um Plano

### Issues

Hyperdrive aceita qualquer issue. Seja redigido livremente, desprovido de informação ou simplesmente burro. O feedback é um presente e será tratado como tal. Nenhuma pergunta é estupida, mesmo as estupidas.

### Pull requests

Envie uma issue e abra PRs e o PR contra a issue para fecha-lo. Isso estabelece uma necessidade (o problema) e ajuda a separar a necessidade da implementação (o pull), resultando em soluções mais robustas.

Antes de trabalhar em um pull, instale e configure o [EditorConfig](http://editorconfig.org/) para seu editor ou IDE para ajudar a normalizar sua sintaxe de codigo com a do projeto.

## Licença

[![AGPL-3.0 ou qualquer versão posterior](https://img.shields.io/github/license/vhs/hyperdrive.svg?style=flat-square)](https://codeberg.org/vhs/hyperdrive/blob/master/COPYING)
