<?

class HorarioRestaurante extends ActiveRecord\Model {

    static $table_name = 'horario_restaurante';
    static $belongs_to = array(
        array('restaurante')
    );
    
    public function get_hora_inicio1() {
        return substr(StringUtil::formataHora($this->read_attribute('hora_inicio1')), 0, 5);
    }

    public function hash() {
        $md5 = '';
        $to_md5 = '';
        $attributes = $this->attributes();

        if ($attributes) {
            foreach ($attributes as $key => $attr) {
                if ($key != 'id' && $key != 'restaurante_id') {
                    $to_md5 .= ((string) $attr) . '-';
                }
            }

            $md5 = md5($to_md5);
        }

        return $md5;
    }

    public function __toString() {
        $str = $this->dia_da_semana;

        if ($this->hora_inicio1 && $this->hora_fim1) {
            $str .= ' - ' . StringUtil::formataHora($this->hora_inicio1) . ' &agrave;s ' . StringUtil::formataHora($this->hora_fim1);
        }

        if ($this->hora_inicio2 && $this->hora_fim2) {
            if ($this->hora_inicio1 && $this->hora_fim1) {
                $str .= ' / ';
            } else {
                $str .= ' - ';
            }

            $str .= StringUtil::formataHora($this->hora_inicio2) . ' &agrave;s ' . StringUtil::formataHora($this->hora_fim2);
        }

        if ($this->hora_inicio3 && $this->hora_fim3) {
            if (($this->hora_inicio1 && $this->hora_fim1) || ($this->hora_inicio2 && $this->hora_fim2)) {
                $str .= ' / ';
            } else {
                $str .= ' - ';
            }

            $str .= StringUtil::formataHora($this->hora_inicio3) . ' &agrave;s ' . StringUtil::formataHora($this->hora_fim3);
        }

        return $str;
    }

}

?>