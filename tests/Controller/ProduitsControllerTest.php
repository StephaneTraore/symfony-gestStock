<?php

namespace App\Test\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProduitsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ProduitsRepository $repository;
    private string $path = '/produits/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Produits::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Produit index');

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
            'produit[nomProduit]' => 'Testing',
            'produit[categoriesProduit]' => 'Testing',
            'produit[descriptionProduit]' => 'Testing',
            'produit[prixProduit]' => 'Testing',
            'produit[dateFabrication]' => 'Testing',
            'produit[dateExpiration]' => 'Testing',
        ]);

        self::assertResponseRedirects('/produits/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setNomProduit('My Title');
        $fixture->setCategoriesProduit('My Title');
        $fixture->setDescriptionProduit('My Title');
        $fixture->setPrixProduit('My Title');
        $fixture->setDateFabrication('My Title');
        $fixture->setDateExpiration('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Produit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setNomProduit('My Title');
        $fixture->setCategoriesProduit('My Title');
        $fixture->setDescriptionProduit('My Title');
        $fixture->setPrixProduit('My Title');
        $fixture->setDateFabrication('My Title');
        $fixture->setDateExpiration('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'produit[nomProduit]' => 'Something New',
            'produit[categoriesProduit]' => 'Something New',
            'produit[descriptionProduit]' => 'Something New',
            'produit[prixProduit]' => 'Something New',
            'produit[dateFabrication]' => 'Something New',
            'produit[dateExpiration]' => 'Something New',
        ]);

        self::assertResponseRedirects('/produits/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomProduit());
        self::assertSame('Something New', $fixture[0]->getCategoriesProduit());
        self::assertSame('Something New', $fixture[0]->getDescriptionProduit());
        self::assertSame('Something New', $fixture[0]->getPrixProduit());
        self::assertSame('Something New', $fixture[0]->getDateFabrication());
        self::assertSame('Something New', $fixture[0]->getDateExpiration());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Produits();
        $fixture->setNomProduit('My Title');
        $fixture->setCategoriesProduit('My Title');
        $fixture->setDescriptionProduit('My Title');
        $fixture->setPrixProduit('My Title');
        $fixture->setDateFabrication('My Title');
        $fixture->setDateExpiration('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/produits/');
    }
}
