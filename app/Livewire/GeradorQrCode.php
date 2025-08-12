<?php

namespace App\Livewire;

use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GeradorQrCode extends Component
{
    public $qrcode = null;
    public $qrcode_link = null;
    public $url = null;

    public $cor_principal = '#000000';
    public $cor_principal_r = 0;
    public $cor_principal_g = 0;
    public $cor_principal_b = 0;

    public $cor_fundo = '#ffffff';
    public $cor_fundo_r = 255;
    public $cor_fundo_g = 255;
    public $cor_fundo_b = 255;

    public $gradient_select = false;
    public $gradient_from = '#ffffff';
    public $gradient_to = '#737373';
    public $gradient_from_array = [255, 255, 255];
    public $gradient_to_array = [115, 115, 115];

    public $margem = 1;
    public $tamanho = 500;
    public $estilo_principal = 'square';
    public $estilo_olhos = 'square';

    protected function rules()
    {
        return [
            'url' => ['required'],
        ];
    }

    public function mount()
    {
        $this->url = request()->query('url');
    }

    public function updated($prop)
    {
        $this->validateOnly($prop);
    }

    public function transformCorPrincipal()
    {
        list(
            $this->cor_principal_r, 
            $this->cor_principal_g, 
            $this->cor_principal_b
        ) = sscanf($this->cor_principal, "#%02x%02x%02x");
    }

    public function transformCorFundo()
    {
        list(
            $this->cor_fundo_r, 
            $this->cor_fundo_g, 
            $this->cor_fundo_b
        ) = sscanf($this->cor_fundo, "#%02x%02x%02x");
    }

    public function transformCorGradiente()
    {
        list( $a, $b, $c ) = sscanf($this->gradient_from, "#%02x%02x%02x");
        $this->gradient_from_array = [$a, $b, $c];

        list( $d, $e, $f ) = sscanf($this->gradient_to, "#%02x%02x%02x");
        $this->gradient_to_array = [$d, $e, $f];
    }

    public function gerarQrCode()
    {
        $this->validate();

        if(!$this->validate()) {
            $this->addError('url', 'Digite um URL válido.');
            return;
        }

        $this->transformCorPrincipal();
        $this->transformCorFundo();

        $manager = new ImageManager(new Driver());
        
        if($this->gradient_select) {

            $this->transformCorGradiente();

            $from = $this->gradient_from_array;
            $to = $this->gradient_to_array;

            $qrBinary = base64_encode(
                QrCode::format('png')
                    ->size($this->tamanho)
                    ->style($this->estilo_principal)
                    ->eye($this->estilo_olhos)
                    ->color($this->cor_principal_r, $this->cor_principal_g, $this->cor_principal_b)
                    ->gradient($from[0], $from[1], $from[2], $to[0], $to[1], $to[2], 'diagonal')
                    ->backgroundColor($this->cor_fundo_r, $this->cor_fundo_g, $this->cor_fundo_b)
                    ->margin($this->margem)
                    ->generate($this->url)
            );
        } else {
            $qrBinary = base64_encode(
                QrCode::format('png')
                    ->size($this->tamanho)
                    ->style($this->estilo_principal)
                    ->eye($this->estilo_olhos)
                    ->color($this->cor_principal_r, $this->cor_principal_g, $this->cor_principal_b)
                    ->backgroundColor($this->cor_fundo_r, $this->cor_fundo_g, $this->cor_fundo_b)
                    ->margin($this->margem)
                    ->generate($this->url)
            );
        }

        $qrImage = $manager->read($qrBinary);

        $iconeSize = intval($this->tamanho * 0.1);

        switch ($this->estilo_principal) {
            case 'square':
                $icone_img = public_path('src/images/icone-k-square.png');
                break;
            case 'dot':
                $icone_img = public_path('src/images/icone-k-dot.png');
                break;
            default:
                $icone_img = public_path('src/images/icone-k-arredondado.png');
                break;
        }

        $icone = $manager
            ->read($icone_img)
            ->resize($iconeSize, $iconeSize);

        $qrImage->place($icone, 'bottom-right', 3, 3);

        $this->qrcode = $qrImage->toPng()->toDataUri();
    }

    public function render()
    {
        return view('livewire.gerador-qr-code')
            ->title('Gerar Qr Code');
    }
}
