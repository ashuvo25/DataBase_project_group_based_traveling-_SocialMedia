 /*******************বিসমিল্লাহির রাহমানির রাহিম **********************/
 /*__________________ MD ASADUZZAMAN SHUVO ______________________ */

#include<bits/stdc++.h>
using namespace std;

#define ll long long
const int INF = 1e9+10;
const int N = 1e5+10;

int main()
{
 int t;cin>>t;
while(t--){
    int n ,k ;cin>> n>>k;
    string s;cin>>s;
    int bc =0;
    for(int  i =0;i< s.size();i++){
            if(s[i] == 'B') bc++;
        } 
        if(bc < k){
            int again = 0;
          for(int i = 0;i< n;i++){
            if(s[i] == 'A') again++;
            if(k-bc == again){
               cout<< 1 <<endl;
               cout<<  i+1 << " " << "B" << endl;break;
            } 
          }
        }
        else if(bc == k) cout<< 0 <<endl;
        else{
          int again = 0;
          for(int i = 0;i< n;i++){
            if(s[i] == 'B') again++;
            if(  again== bc- k){
               cout<< 1 <<endl;
               cout<<  i+1 << " " << "A" << endl;break;
            } 
          }
        }
    
 }

    return 0;
}