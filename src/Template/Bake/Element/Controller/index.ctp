    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
<% $belongsTo = $this->Bake->aliasExtractor($modelObj, 'BelongsTo'); %>
<% if ($belongsTo): %>
        $this->paginate = [
            'contain' => [<%= $this->Bake->stringifyList($belongsTo, ['indent' => false]) %>],
        ];
<% endif; %>
        $<%= $pluralName %> = $this->paginate($this-><%= $currentModelName %>->find('search', $this-><%= $currentModelName %>->filterParams($this->request->query)));

        $this->set(compact('<%= $pluralName %>'));
        $this->set('_serialize', ['<%= $pluralName %>']);
    }
