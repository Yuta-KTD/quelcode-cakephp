<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Bidsendings Controller
 *
 * @property \App\Model\Table\BidsendingsTable $Bidsendings
 *
 * @method \App\Model\Entity\Bidsending[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BidsendingsController extends AuctionBaseController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Bidinfos'],
        ];
        $bidsendings = $this->paginate($this->Bidsendings);

        $this->set(compact('bidsendings'));
    }

    /**
     * View method
     *
     * @param string|null $id Bidsending id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bidsending = $this->Bidsendings->get($id, [
            'contain' => ['Bidinfos'],
        ]);

        $this->set('bidsending', $bidsending);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bidsending = $this->Bidsendings->newEntity();
        if ($this->request->is('post')) {
            $bidsending = $this->Bidsendings->patchEntity($bidsending, $this->request->getData());
            if ($this->Bidsendings->save($bidsending)) {
                $this->Flash->success(__('The bidsending has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bidsending could not be saved. Please, try again.'));
        }
        $bidinfos = $this->Bidsendings->Bidinfos->find('list', ['limit' => 200]);
        $this->set(compact('bidsending', 'bidinfos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bidsending id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bidsending = $this->Bidsendings->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bidsending = $this->Bidsendings->patchEntity($bidsending, $this->request->getData());
            if ($this->Bidsendings->save($bidsending)) {
                $this->Flash->success(__('The bidsending has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bidsending could not be saved. Please, try again.'));
        }
        $bidinfos = $this->Bidsendings->Bidinfos->find('list', ['limit' => 200]);
        $this->set(compact('bidsending', 'bidinfos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bidsending id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bidsending = $this->Bidsendings->get($id);
        if ($this->Bidsendings->delete($bidsending)) {
            $this->Flash->success(__('The bidsending has been deleted.'));
        } else {
            $this->Flash->error(__('The bidsending could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
