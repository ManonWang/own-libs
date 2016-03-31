#include <iostream>
using namespace std;

struct node {
   int data;
   node *next;
};

class LinkList {
    public:
       LinkList();
       int addData(int data);
       int delData(int data);
       node* findFirstData(int data);
       void display();
    private:
        node* head;
};


LinkList::LinkList()
{
    head = new node();
    head->next = NULL;
}   

int LinkList::addData(int data) 
{
    node *p = new node();
    p->data = data;
    p->next = head->next;
    head->next = p;
    p = NULL;
}

int LinkList::delData(int data) 
{   
    if (NULL == head->next) 
    {
        return 0;
    }

    node *p = head;
    node *q = head->next;
    int count = 0;

    while (NULL != q) {
       if (q->data == data) {
          count ++;
          p->next = q->next;
          delete q;
          q = p->next;
       } else {
          p = p->next;
          q = q->next;
       }
    }

    return count;
}

node* LinkList::findFirstData(int data) 
{
    node *p = head->next;
    while (NULL != p) {
        if (p->data = data) {
            return p;
        }
        p = p->next;
    }

    return NULL;
}

void LinkList::display() 
{
    node *p = head->next;
    while (p != NULL) {
        cout << p->data << " ";
        p = p->next;
    }
    p = NULL;
    cout << endl;
}    

int main() 
{
    LinkList *list = new LinkList();
    for (int i = 1; i <= 5; i++)
    {
        list->addData(i);
    }    
    list->display();
    
    node *n = list->findFirstData(3);
    cout << n->data << endl;
    
    list->addData(1);
    list->display();

    list->delData(1);
    list->display();

    return 0;
}
