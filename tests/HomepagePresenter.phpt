<?hh

namespace Tests;

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
class HomepagePresenter extends \Tester\TestCase
{

  use \Testbench\TPresenter;

  public function testHomepage()
  {
    $this->checkAction('Homepage:default');
  }

  public function testHomepageError()
  {
    Assert::exception(function() {
      $this->checkAction('Homepage:error');
    }, 'Nette\Application\BadRequestException');
  }

}

(new HomepagePresenter())->run();
