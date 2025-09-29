<?php

namespace App\Test\Controller;

use App\Entity\Fournisseurs;
use App\Repository\FournisseursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FournisseursControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private FournisseursRepository $repository;
    private string $path = '/fournisseurs/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Fournisseurs::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Fournisseur index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'fournisseur[nomFournisseur]' => 'Testing',
            'fournisseur[prenomFournisseur]' => 'Testing',
            'fournisseur[adresseFournisseur]' => 'Testing',
            'fournisseur[telephoneFournisseur]' => 'Testing',
            'fournisseur[emailFournisseur]' => 'Testing',
        ]);

        self::assertResponseRedirects('/fournisseurs/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Fournisseurs();
        $fixture->setNomFournisseur('My Title');
        $fixture->setPrenomFournisseur('My Title');
        $fixture->setAdresseFournisseur('My Title');
        $fixture->setTelephoneFournisseur('My Title');
        $fixture->setEmailFournisseur('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Fournisseur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Fournisseurs();
        $fixture->setNomFournisseur('My Title');
        $fixture->setPrenomFournisseur('My Title');
        $fixture->setAdresseFournisseur('My Title');
        $fixture->setTelephoneFournisseur('My Title');
        $fixture->setEmailFournisseur('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'fournisseur[nomFournisseur]' => 'Something New',
            'fournisseur[prenomFournisseur]' => 'Something New',
            'fournisseur[adresseFournisseur]' => 'Something New',
            'fournisseur[telephoneFournisseur]' => 'Something New',
            'fournisseur[emailFournisseur]' => 'Something New',
        ]);

        self::assertResponseRedirects('/fournisseurs/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomFournisseur());
        self::assertSame('Something New', $fixture[0]->getPrenomFournisseur());
        self::assertSame('Something New', $fixture[0]->getAdresseFournisseur());
        self::assertSame('Something New', $fixture[0]->getTelephoneFournisseur());
        self::assertSame('Something New', $fixture[0]->getEmailFournisseur());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Fournisseurs();
        $fixture->setNomFournisseur('My Title');
        $fixture->setPrenomFournisseur('My Title');
        $fixture->setAdresseFournisseur('My Title');
        $fixture->setTelephoneFournisseur('My Title');
        $fixture->setEmailFournisseur('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/fournisseurs/');
    }
}
