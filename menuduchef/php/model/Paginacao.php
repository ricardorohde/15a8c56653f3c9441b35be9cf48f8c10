<?

/**
 * Classe para manipular a paginação
 */
class Paginacao {
    
    /* Propriedades de inicialização */
    var $class;
    var $options;
    var $urlBase;
    var $page;
    var $maxPerPage;
    var $visibleNumbers;
    var $delimiter;

    /* Propriedades setadas ao inicializar */
    var $count;
    var $previous;
    var $next;
    var $last;
    var $list;

    public function __construct($class, $options = null, $urlBase = '', $page = 1, $maxPerPage = 5, $visibleNumbers = 5, $delimiter = '/page/') {
	if (!$options) {
	    $options = array();
	}

	$this->class = $class;
	$this->options = $options;
	$this->urlBase = $urlBase;
	$this->page = $page;
	$this->maxPerPage = $maxPerPage;
	$this->visibleNumbers = $visibleNumbers;
	$this->delimiter = $delimiter;

	$this->count = $class::count($this->options);

	if ($this->count) {
	    $this->last = ceil($this->count / $this->maxPerPage);
	    $this->previous = $this->page > 1 ? ($this->page - 1) : 1;
	    $this->next = $this->page < $this->last ? ($this->page + 1) : $this->last;

	    $offset = ($this->page * $this->maxPerPage) - $this->maxPerPage;

	    $this->list = $class::all(array_merge($options, array('limit' => $this->maxPerPage, 'offset' => $offset)));
	}
    }

    public function getHtml() {
	$html = '';

	if ($this->count > $this->maxPerPage) {
	    if ($this->page == 1) {
		$html .= '<a href="javascript:void(0)"><<</a>';
	    } else {
		$html .= '<a href="' . $this->urlBase . $this->delimiter . $this->previous . '/"><<</a>';
	    }

	    $initNumbers = ($this->page - $this->visibleNumbers) > 0 ? ($this->page - $this->visibleNumbers) : 1;
	    $finishNumbers = ($this->page + $this->visibleNumbers) < $this->last ? ($this->page + $this->visibleNumbers) : $this->last;

	    for ($i = $initNumbers; $i <= $finishNumbers; $i++) {
		$html .= '<a ' . ($i == $this->page ? 'class="marked"' : '') . ' href="' . $this->urlBase . $this->delimiter . $i . '/">' . $i . '</a>';
	    }

	    if ($this->page == $this->last) {
		$html .= '<a href="javascript:void(0)">>></a>';
	    } else {
		$html .= '<a href="' . $this->urlBase . $this->delimiter . $this->next . '/">>></a>';
	    }
	}

	return $html;
    }

}

?>