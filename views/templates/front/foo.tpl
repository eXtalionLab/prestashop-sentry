
{extends file='page.tpl'}

{block name='page_content_top'}
  <h1>Hello from ModuleName</h1>
{/block}

{block name='page_content'}
  <p>
    Var foo = "<span class="var">{$foo}</span>".
  </p>
{/block}
